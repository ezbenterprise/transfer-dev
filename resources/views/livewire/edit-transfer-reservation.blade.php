<div>



    <div class="divider"></div>
    <x-flatpickr
        :class="$reservation->isDirty('date_time')?'border-success':''"
        label="Date & time:"
        :default-date="$this->date"
        wire:model.defer.defer="date"
    ></x-flatpickr>

    @if($this->is_out_transfer)
        <div class="divider"></div>
        <x-flatpickr
            label="Guest Pick up:"
            :default-date="$this->guest_pick_up"
            wire:model.defer.defer="guest_pick_up"
        ></x-flatpickr>
    @endif


    <x-input :class="$reservation->isDirty('adults')?'border-success':''"
                          wire:model.defer="adults"
             type="number"
                          label="Adults"
    />
    <x-input
        :class="$reservation->isDirty('children')?'border-success':''"
        wire:model.defer="children"
        type="number"

        label="Children"
    />
    <x-input
        :class="$reservation->isDirty('infants')?'border-success':''"
        wire:model.defer="infants"
        type="number"

        label="Infants"
    />
    <x-input
        :class="$reservation->isDirty('luggage')?'border-success':''"
        wire:model.defer="luggage"
        type="number"

        label="Luggage"
    />
    <x-input
        :class="$reservation->isDirty('flight_number')?'border-success':''"
        wire:model.defer="flight_number"
                          label="Flight number"
    />

    <x-textarea
        label="Remark:"
        wire:model.defer="remark"
    />


    <br/>
                @if($this->available_extras->isNotEmpty())

                    <table class="ds-table w-full">
                        <!-- head -->
                        <thead>
                        <tr>
                            <th>
                                Select
                            </th>
                            <th>Name</th>
                            <th>Price</th>
                        </tr>
                        </thead>
                        <tbody>


                        @foreach($this->available_extras as $extra)

                            <tr>
                                <th>
                                    <x-checkbox
                                        lg
                                        wire:model="reservation_extras.{{$extra->id}}"
                                    />
                                </th>
                                <td>
                                    <div class="flex items-center space-x-3">
                                        <div class="ds-avatar">
                                            <div class="ds-mask ds-mask-squircle w-12 h-12">
                                                <img src="{{$extra->primaryImageUrl}}"/>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="font-bold"> {{$extra->name}}</div>
                                            <div
                                                class="text-sm opacity-50">{{Str::limit($extra->description,70)}}</div>
                                        </div>
                                    </div>
                                </td>

                                <td>{{Cknow\Money\Money::EUR($extra->partner->first()?->pivot->price)}}</td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <x-input-alert type="info">In case of RoundTrip, extras settings will be automatically applied to both directions.</x-input-alert>
                @else
                    <x-input-alert type="warning">No extras for selected partner</x-input-alert>
                @endif

    <br/>
    <x-native-select
        label="Send Modify Email:"
        :options="[
            ['name' => 'Yes',  'id' => 1],
            ['name' => 'No', 'id' => 0],
        ]"
        option-label="name"
        option-value="id"
        wire:model.defer="sendModifyMail"
    />
    <div class=" my-4">
        <x-button positive wire:click="confirmationDialog">
            Save
        </x-button>
        <x-button  wire:click="cancel">
            Cancel
        </x-button>
    </div>

</div>
