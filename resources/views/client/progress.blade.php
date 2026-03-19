<x-layouts.app :title="'Tu progreso'">
    <main class="shell">
        @include('client.partials.nav', ['active' => 'progress'])
        @if (session('status'))
            <div class="flash">{{ session('status') }}</div>
        @endif
        <section class="card" style="margin-bottom:1.25rem">
            <p class="eyebrow">Seguimiento físico</p>
            <h1>Tu progreso corporal</h1>
            <p class="muted">Aquí puedes mantener tus datos al día y registrar mediciones mensuales para comparar peso, grasa y masa muscular.</p>
        </section>

        <section class="grid two" style="margin-bottom:1.25rem">
            <article class="card">
                <div>
                    <p class="eyebrow">Perfil actual</p>
                    <h2>Tus datos base</h2>
                    <p class="muted" style="margin:0 0 1.25rem">Puedes dejarlos en 0 si una métrica todavía no está medida.</p>
                </div>
                <form method="POST" action="{{ route('client.profile.update') }}" class="stack">
                    @csrf
                    @method('PUT')
                    <div class="form-grid">
                        <div>
                            <label for="age">Edad</label>
                            <input id="age" name="age" type="number" min="0" step="1" value="{{ old('age', $user->age) }}">
                            @error('age') <div class="error">{{ $message }}</div> @enderror
                        </div>
                        <div>
                            <label for="training_years">Años entrenando</label>
                            <input id="training_years" name="training_years" type="number" min="0" step="1" value="{{ old('training_years', $user->training_years) }}">
                            @error('training_years') <div class="error">{{ $message }}</div> @enderror
                        </div>
                        <div>
                            <label for="height_cm">Altura (cm)</label>
                            <input id="height_cm" name="height_cm" type="number" min="0" step="0.01" value="{{ old('height_cm', $user->height_cm) }}">
                            @error('height_cm') <div class="error">{{ $message }}</div> @enderror
                        </div>
                        <div>
                            <label for="weight_kg">Peso (kg)</label>
                            <input id="weight_kg" name="weight_kg" type="number" min="0" step="0.01" value="{{ old('weight_kg', $user->weight_kg) }}">
                            @error('weight_kg') <div class="error">{{ $message }}</div> @enderror
                        </div>
                        <div>
                            <label for="body_mass_index">IMC</label>
                            <input id="body_mass_index" name="body_mass_index" type="number" min="0" step="0.01" value="{{ old('body_mass_index', $user->body_mass_index) }}">
                            @error('body_mass_index') <div class="error">{{ $message }}</div> @enderror
                        </div>
                        <div>
                            <label for="muscle_mass_index">Índice masa muscular</label>
                            <input id="muscle_mass_index" name="muscle_mass_index" type="number" min="0" step="0.01" value="{{ old('muscle_mass_index', $user->muscle_mass_index) }}">
                            @error('muscle_mass_index') <div class="error">{{ $message }}</div> @enderror
                        </div>
                        <div>
                            <label for="body_fat_percentage">% grasa corporal</label>
                            <input id="body_fat_percentage" name="body_fat_percentage" type="number" min="0" step="0.01" value="{{ old('body_fat_percentage', $user->body_fat_percentage) }}">
                            @error('body_fat_percentage') <div class="error">{{ $message }}</div> @enderror
                        </div>
                        <div>
                            <label for="muscle_mass_kg">Masa muscular (kg)</label>
                            <input id="muscle_mass_kg" name="muscle_mass_kg" type="number" min="0" step="0.01" value="{{ old('muscle_mass_kg', $user->muscle_mass_kg) }}">
                            @error('muscle_mass_kg') <div class="error">{{ $message }}</div> @enderror
                        </div>
                        <div>
                            <label for="goal_weight_kg">Peso objetivo (kg)</label>
                            <input id="goal_weight_kg" name="goal_weight_kg" type="number" min="0" step="0.01" value="{{ old('goal_weight_kg', $user->goal_weight_kg) }}">
                            @error('goal_weight_kg') <div class="error">{{ $message }}</div> @enderror
                        </div>
                        <div>
                            <label for="waist_cm">Cintura (cm)</label>
                            <input id="waist_cm" name="waist_cm" type="number" min="0" step="0.01" value="{{ old('waist_cm', $user->waist_cm) }}">
                            @error('waist_cm') <div class="error">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <button class="btn-primary" type="submit">Guardar perfil</button>
                </form>
            </article>

            <article class="card">
                <div>
                    <p class="eyebrow">{{ $editMeasurement ? 'Editar medición' : 'Nueva medición' }}</p>
                    <h2>{{ $editMeasurement ? 'Corregir progreso' : 'Registrar progreso' }}</h2>
                    <p class="muted" style="margin:0 0 1.25rem">
                        {{ $editMeasurement ? 'Corrige cualquier valor erróneo y los gráficos se actualizarán con el cambio.' : 'Cada nuevo registro se guarda en tu histórico y actualiza tus datos actuales.' }}
                    </p>
                </div>
                <form method="POST" action="{{ $editMeasurement ? route('client.measurements.update', $editMeasurement) : route('client.measurements.store') }}" class="stack">
                    @csrf
                    @if ($editMeasurement)
                        @method('PUT')
                    @endif
                    <div class="form-grid">
                        <div>
                            <label for="measured_at">Fecha</label>
                            <input id="measured_at" name="measured_at" type="date" value="{{ old('measured_at', $editMeasurement?->measured_at?->toDateString() ?? now()->toDateString()) }}">
                            @error('measured_at') <div class="error">{{ $message }}</div> @enderror
                        </div>
                        <div>
                            <label for="measure-age">Edad</label>
                            <input id="measure-age" name="age" type="number" min="0" step="1" value="{{ old('age', $editMeasurement?->age ?? $user->age) }}">
                        </div>
                        <div>
                            <label for="measure-training-years">Años entrenando</label>
                            <input id="measure-training-years" name="training_years" type="number" min="0" step="1" value="{{ old('training_years', $editMeasurement?->training_years ?? $user->training_years) }}">
                        </div>
                        <div>
                            <label for="measure-height-cm">Altura (cm)</label>
                            <input id="measure-height-cm" name="height_cm" type="number" min="0" step="0.01" value="{{ old('height_cm', $editMeasurement?->height_cm ?? $user->height_cm) }}">
                        </div>
                        <div>
                            <label for="measure-weight-kg">Peso (kg)</label>
                            <input id="measure-weight-kg" name="weight_kg" type="number" min="0" step="0.01" value="{{ old('weight_kg', $editMeasurement?->weight_kg ?? $user->weight_kg) }}">
                        </div>
                        <div>
                            <label for="measure-body-mass-index">IMC</label>
                            <input id="measure-body-mass-index" name="body_mass_index" type="number" min="0" step="0.01" value="{{ old('body_mass_index', $editMeasurement?->body_mass_index ?? $user->body_mass_index) }}">
                        </div>
                        <div>
                            <label for="measure-muscle-mass-index">Índice masa muscular</label>
                            <input id="measure-muscle-mass-index" name="muscle_mass_index" type="number" min="0" step="0.01" value="{{ old('muscle_mass_index', $editMeasurement?->muscle_mass_index ?? $user->muscle_mass_index) }}">
                        </div>
                        <div>
                            <label for="measure-body-fat-percentage">% grasa corporal</label>
                            <input id="measure-body-fat-percentage" name="body_fat_percentage" type="number" min="0" step="0.01" value="{{ old('body_fat_percentage', $editMeasurement?->body_fat_percentage ?? $user->body_fat_percentage) }}">
                        </div>
                        <div>
                            <label for="measure-muscle-mass-kg">Masa muscular (kg)</label>
                            <input id="measure-muscle-mass-kg" name="muscle_mass_kg" type="number" min="0" step="0.01" value="{{ old('muscle_mass_kg', $editMeasurement?->muscle_mass_kg ?? $user->muscle_mass_kg) }}">
                        </div>
                        <div>
                            <label for="measure-goal-weight-kg">Peso objetivo (kg)</label>
                            <input id="measure-goal-weight-kg" name="goal_weight_kg" type="number" min="0" step="0.01" value="{{ old('goal_weight_kg', $editMeasurement?->goal_weight_kg ?? $user->goal_weight_kg) }}">
                        </div>
                        <div>
                            <label for="measure-waist-cm">Cintura (cm)</label>
                            <input id="measure-waist-cm" name="waist_cm" type="number" min="0" step="0.01" value="{{ old('waist_cm', $editMeasurement?->waist_cm ?? $user->waist_cm) }}">
                        </div>
                    </div>
                    <div>
                        <label for="notes">Notas de la medición</label>
                        <textarea id="notes" name="notes">{{ old('notes', $editMeasurement?->notes) }}</textarea>
                        @error('notes') <div class="error">{{ $message }}</div> @enderror
                    </div>
                    <div class="actions-inline">
                        <button class="btn-primary" type="submit" style="width:auto">
                            {{ $editMeasurement ? 'Guardar cambios' : 'Guardar medición' }}
                        </button>
                        @if ($editMeasurement)
                            <a href="{{ route('client.progress') }}" class="btn-secondary">Cancelar edición</a>
                        @endif
                    </div>
                </form>
            </article>
        </section>

        <section class="card" style="margin-bottom:1.25rem">
            <p class="eyebrow">Gráficas</p>
            <h2 style="margin-bottom:1rem">Resultados conseguidos</h2>
            <div class="grid two">
                @foreach ($chartSeries as $series)
                    @include('client.partials.progress-chart', ['series' => $series])
                @endforeach
            </div>
        </section>

        <section class="card">
            <p class="eyebrow">Histórico</p>
            <h2 style="margin-bottom:1rem">Tus mediciones</h2>
            @if ($measurementHistory->isNotEmpty())
                <div class="table-wrap">
                    <table class="metrics">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Peso</th>
                                <th>% grasa</th>
                                <th>Masa muscular</th>
                                <th>IMC</th>
                                <th>Cintura</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($measurementHistory as $measurement)
                                <tr>
                                    <td>{{ $measurement->measured_at->format('d/m/Y') }}</td>
                                    <td>{{ number_format((float) $measurement->weight_kg, 1) }} kg</td>
                                    <td>{{ number_format((float) $measurement->body_fat_percentage, 1) }}%</td>
                                    <td>{{ number_format((float) $measurement->muscle_mass_kg, 1) }} kg</td>
                                    <td>{{ number_format((float) $measurement->body_mass_index, 1) }}</td>
                                    <td>{{ number_format((float) $measurement->waist_cm, 1) }} cm</td>
                                    <td>
                                        <div class="actions-inline">
                                            <a href="{{ route('client.progress', ['edit' => $measurement->id]) }}" class="btn-secondary">Editar</a>
                                            <form method="POST" action="{{ route('client.measurements.destroy', $measurement) }}" onsubmit="return confirm('¿Quieres eliminar esta medición?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-danger">Eliminar</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="muted">Todavía no has guardado ninguna medición. La primera que añadas aparecerá aquí y activará las gráficas.</p>
            @endif
        </section>
    </main>
</x-layouts.app>
