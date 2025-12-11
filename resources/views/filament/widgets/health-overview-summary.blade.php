<x-filament::widget>
    <x-filament::card>
        <div class="flex flex-col gap-4">

            <h3 class="text-sm font-semibold text-gray-700">
                Health Breakdown
            </h3>

            <div class="space-y-2 text-sm">

                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="h-3 w-3 rounded-full" style="background-color:#00A651;"></span>
                        <span>Fit</span>
                    </div>
                    <span class="font-semibold text-gray-900">{{ $fit }}</span>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="h-3 w-3 rounded-full" style="background-color:#F4C300;"></span>
                        <span>Requires Therapy</span>
                    </div>
                    <span class="font-semibold text-gray-900">{{ $requiresTherapy }}</span>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="h-3 w-3 rounded-full" style="background-color:#EE334E;"></span>
                        <span>Restricted</span>
                    </div>
                    <span class="font-semibold text-gray-900">{{ $restricted }}</span>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="h-3 w-3 rounded-full" style="background-color:#0081C8;"></span>
                        <span>Pending Screening</span>
                    </div>
                    <span class="font-semibold text-gray-900">{{ $pending }}</span>
                </div>

            </div>

        </div>
    </x-filament::card>
</x-filament::widget>
