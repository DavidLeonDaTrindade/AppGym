<?php

namespace App\Services;

use App\Models\Food;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RuntimeException;
use SimpleXMLElement;
use XMLReader;
use ZipArchive;

class AesanFoodImporter
{
    /**
     * @return array{imported:int, file:string}
     */
    public function importForTrainer(User $trainer, string $filePath, bool $replace = true): array
    {
        ini_set('memory_limit', '1024M');
        set_time_limit(0);

        if (! is_file($filePath)) {
            throw new RuntimeException('No existe el fichero de AESAN: ' . $filePath);
        }

        $zip = new ZipArchive();

        if ($zip->open($filePath) !== true) {
            throw new RuntimeException('No se pudo abrir el fichero XLSX de AESAN.');
        }

        $sharedStringsXml = $zip->getFromName('xl/sharedStrings.xml');
        $sheetXml = $zip->getFromName('xl/worksheets/sheet2.xml');
        $zip->close();

        if (! $sharedStringsXml || ! $sheetXml) {
            throw new RuntimeException('El fichero de AESAN no contiene la hoja DATOS esperada.');
        }

        $sharedStrings = $this->parseSharedStrings($sharedStringsXml);
        $imported = 0;

        if ($replace) {
            DB::table('diet_foods')
                ->whereIn('food_id', Food::query()->where('trainer_id', $trainer->id)->pluck('id'))
                ->delete();

            Food::query()->where('trainer_id', $trainer->id)->delete();
        }

        $batch = [];
        $now = now();

        foreach ($this->iterateRows($sheetXml, $sharedStrings) as $rowNumber => $row) {
            if ($rowNumber < 3) {
                continue;
            }

            $name = trim((string) ($row['H'] ?? ''));

            if ($name === '') {
                continue;
            }

            $batch[] = [
                'trainer_id' => $trainer->id,
                'name' => Str::limit($name, 255, ''),
                'brand' => $this->nullable(Str::limit((string) ($row['I'] ?? ''), 255, '')),
                'serving_reference' => '100 g / 100 ml',
                'calories_kcal' => $this->decimal($row['M'] ?? 0),
                'protein_g' => $this->decimal($row['R'] ?? 0),
                'carbs_g' => $this->decimal($row['P'] ?? 0),
                'fat_g' => $this->decimal($row['N'] ?? 0),
                'fiber_g' => 0,
                'sugar_g' => $this->decimal($row['Q'] ?? 0),
                'sodium_mg' => round($this->decimal($row['S'] ?? 0) * 1000 * 0.4, 2),
                'notes' => $this->buildNotes($row),
                'source' => 'aesan_2022',
                'external_id' => $this->nullable(Str::limit((string) ($row['G'] ?? ''), 120, '')),
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            if (count($batch) >= 500) {
                DB::table('foods')->insert($batch);
                $imported += count($batch);
                $batch = [];
            }
        }

        if ($batch !== []) {
            DB::table('foods')->insert($batch);
            $imported += count($batch);
        }

        return [
            'imported' => $imported,
            'file' => $filePath,
        ];
    }

    /**
     * @return array<int, string>
     */
    private function parseSharedStrings(string $xml): array
    {
        $root = new SimpleXMLElement($xml);
        $root->registerXPathNamespace('a', 'http://schemas.openxmlformats.org/spreadsheetml/2006/main');

        $strings = [];

        foreach ($root->xpath('//a:si') as $item) {
            $item->registerXPathNamespace('a', 'http://schemas.openxmlformats.org/spreadsheetml/2006/main');
            $texts = $item->xpath('.//a:t');
            $value = '';

            foreach ($texts ?: [] as $text) {
                $value .= (string) $text;
            }

            $strings[] = $value;
        }

        return $strings;
    }

    /**
     * @return \Generator<int, array<string, string>>
     */
    private function iterateRows(string $sheetXml, array $sharedStrings): \Generator
    {
        $reader = new XMLReader();
        $reader->XML($sheetXml);

        while ($reader->read()) {
            if ($reader->nodeType !== XMLReader::ELEMENT || $reader->localName !== 'row') {
                continue;
            }

            $rowNumber = (int) $reader->getAttribute('r');
            $rowXml = $reader->readOuterXml();
            $rowElement = new SimpleXMLElement($rowXml);
            $rowElement->registerXPathNamespace('a', 'http://schemas.openxmlformats.org/spreadsheetml/2006/main');

            $values = [];

            foreach ($rowElement->xpath('./a:c') ?: [] as $cell) {
                $ref = (string) ($cell['r'] ?? '');
                $column = preg_replace('/\d+/', '', $ref) ?: '';
                $type = (string) ($cell['t'] ?? '');
                $raw = (string) ($cell->v ?? '');

                if ($type === 's') {
                    $values[$column] = $sharedStrings[(int) $raw] ?? '';
                } else {
                    $values[$column] = $raw;
                }
            }

            yield $rowNumber => $values;
        }

        $reader->close();
    }

    /**
     * @param  array<string, string>  $row
     */
    private function buildNotes(array $row): string
    {
        $parts = array_filter([
            isset($row['B'], $row['D']) ? 'Categoría: ' . $row['B'] . ' / ' . $row['D'] : null,
            ! empty($row['J']) ? 'Denominación legal: ' . $row['J'] : null,
            ! empty($row['K']) ? 'Ingredientes: ' . $row['K'] : null,
            ! empty($row['F']) ? 'Fuente: ' . $row['F'] : null,
        ]);

        return implode("\n", $parts);
    }

    private function decimal(string|int|float|null $value): float
    {
        if ($value === null || $value === '') {
            return 0;
        }

        return round((float) str_replace(',', '.', (string) $value), 2);
    }

    private function nullable(?string $value): ?string
    {
        $value = trim((string) $value);

        return $value === '' ? null : $value;
    }
}
