<x-filament::widget>
    <div class="gft-kpi-grid">

        {{-- Total Athletes --}}
        <div class="gft-kpi-card gft-kpi-blue">
            <div class="gft-kpi-top">
                <div>
                    <div class="gft-kpi-label">Total Atlet</div>
                    <div class="gft-kpi-value">{{ number_format($totalAthletes ?? 0) }}</div>
                </div>
                <div class="gft-kpi-icon">
                    <x-heroicon-o-user-group class="w-5 h-5" />
                </div>
            </div>
            <div class="gft-kpi-underline"></div>
        </div>

        {{-- Gold --}}
        <div class="gft-kpi-card gft-kpi-gold">
            <div class="gft-kpi-top">
                <div>
                    <div class="gft-kpi-label">Medali Emas</div>
                    <div class="gft-kpi-value">{{ number_format($gold ?? 0) }}</div>
                </div>
                <div class="gft-kpi-icon">
                    <x-heroicon-o-trophy class="w-5 h-5" />
                </div>
            </div>
            <div class="gft-kpi-underline"></div>
        </div>

        {{-- Silver --}}
        <div class="gft-kpi-card gft-kpi-silver">
            <div class="gft-kpi-top">
                <div>
                    <div class="gft-kpi-label">Medali Perak</div>
                    <div class="gft-kpi-value">{{ number_format($silver ?? 0) }}</div>
                </div>
                <div class="gft-kpi-icon">
                    <x-heroicon-o-trophy class="w-5 h-5" />
                </div>
            </div>
            <div class="gft-kpi-underline"></div>
        </div>

        {{-- Bronze --}}
        <div class="gft-kpi-card gft-kpi-bronze">
            <div class="gft-kpi-top">
                <div>
                    <div class="gft-kpi-label">Medali Perunggu</div>
                    <div class="gft-kpi-value">{{ number_format($bronze ?? 0) }}</div>
                </div>
                <div class="gft-kpi-icon">
                    <x-heroicon-o-trophy class="w-5 h-5" />
                </div>
            </div>
            <div class="gft-kpi-underline"></div>
        </div>

    </div>
</x-filament::widget>
