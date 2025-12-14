<div class="gft-health-overview gft-health-overview--full">
    <div class="gft-health-scroll">
        <div class="gft-health-track">

            {{-- Total --}}
            <div class="gft-kpi-card gft-kpi-blue">
                <div class="gft-kpi-top">
                    <div>
                        <div class="gft-kpi-label">Total Athletes</div>
                        <div class="gft-kpi-value">{{ $totalAthletes }}</div>
                    </div>

                    <div class="gft-kpi-icon">
                        <x-filament::icon icon="heroicon-o-user-group" class="w-6 h-6" />
                    </div>
                </div>
                <div class="gft-kpi-underline"></div>
            </div>

            {{-- Fit --}}
            <div class="gft-kpi-card gft-kpi-green">
                <div class="gft-kpi-top">
                    <div>
                        <div class="gft-kpi-label">Fit</div>
                        <div class="gft-kpi-value">{{ $athleteFit }}</div>
                    </div>

                    <div class="gft-kpi-icon">
                        <x-filament::icon icon="heroicon-o-check-circle" class="w-6 h-6" />
                    </div>
                </div>
                <div class="gft-kpi-underline"></div>
            </div>

            {{-- Dalam Pemantauan --}}
            <div class="gft-kpi-card gft-kpi-gold">
                <div class="gft-kpi-top">
                    <div>
                        <div class="gft-kpi-label">Dalam Pemantauan</div>
                        <div class="gft-kpi-value">{{ $underMonitoring }}</div>
                    </div>

                    <div class="gft-kpi-icon">
                        <x-filament::icon icon="heroicon-o-eye" class="w-6 h-6" />
                    </div>
                </div>
                <div class="gft-kpi-underline"></div>
            </div>

            {{-- Sedang Terapi --}}
            <div class="gft-kpi-card gft-kpi-blue">
                <div class="gft-kpi-top">
                    <div>
                        <div class="gft-kpi-label">Sedang Terapi</div>
                        <div class="gft-kpi-value">{{ $inTherapy }}</div>
                    </div>

                    <div class="gft-kpi-icon">
                        <x-filament::icon icon="heroicon-o-heart" class="w-6 h-6" />
                    </div>
                </div>
                <div class="gft-kpi-underline"></div>
            </div>

            {{-- Terbatas --}}
            <div class="gft-kpi-card gft-kpi-crimson">
                <div class="gft-kpi-top">
                    <div>
                        <div class="gft-kpi-label">Terbatas</div>
                        <div class="gft-kpi-value">{{ $restricted }}</div>
                    </div>

                    <div class="gft-kpi-icon">
                        <x-filament::icon icon="heroicon-o-exclamation-triangle" class="w-6 h-6" />
                    </div>
                </div>
                <div class="gft-kpi-underline"></div>
            </div>

            {{-- Belum Screening --}}
            <div class="gft-kpi-card gft-kpi-silver">
                <div class="gft-kpi-top">
                    <div>
                        <div class="gft-kpi-label">Belum Screening</div>
                        <div class="gft-kpi-value">{{ $notScreened }}</div>
                    </div>

                    <div class="gft-kpi-icon">
                        <x-filament::icon icon="heroicon-o-clock" class="w-6 h-6" />
                    </div>
                </div>
                <div class="gft-kpi-underline"></div>
            </div>

        </div>
    </div>
</div>
