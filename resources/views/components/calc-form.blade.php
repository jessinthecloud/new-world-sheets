@props([
    'action',
    'amountLabel', 'amountName', 'amountValue',
    'craftedItemLabel', 'craftedItemName', 'craftedItemValue',
    'materialLabel1', 'materialName1', 'materialValues1',
    'materialLabel2', 'materialName2', 'materialValues2',
    'skillLevelLabel', 'skillLevelName', 'skillLevelValue'
])

<form action="{{ $action }}" method="POST" class="flex flex-wrap justify-end">
    @csrf
    
{{--    @method()--}}
    <div class="field lg:mr-4">
        <x-label class="mb-1 mt-4">
            {{ $amountLabel }}
        </x-label>
        @if($errors->has($amountName))
            <x-input type="text" name="{{ $amountName }}" :value="$amountValue" class="border-red-500"></x-input>
        @else
            <x-input type="text" name="{{ $amountName }}" :value="$amountValue"></x-input>
        @endif
        @error($amountName)
            <div class="alert alert-danger mt-1 text-red-700 text-red-700 ">{{ $message }}</div>
        @enderror
    </div>

    <div class="field lg:mr-4">
        <x-label class="mb-1 mt-4">
            {{ $craftedItemLabel }}
        </x-label>
        @if($errors->has($craftedItemName)) 
            <x-select name="{{ $craftedItemName }}" class="border-red-500">
                {!! $craftedItemValue !!}
            </x-select>
        @else
            <x-select name="{{ $craftedItemName }}">
                {!! $craftedItemValue !!}
            </x-select>
        @endif 
            
        @error($craftedItemName)
            <div class="alert alert-danger mt-1 text-red-700">{{ $message }}</div>
        @enderror
    </div>

    <div class="field lg:mr-4">
        <x-label class="mb-1 mt-4">
            {{ $materialLabel1 }}
        </x-label>
        @if($errors->has($materialName1)) 
            <x-select name="{{ $materialName1 }}" class="border-red-500">
                {!! $materialValues1 !!}
            </x-select>
        @else
            <x-select name="{{ $materialName1 }}">
                {!! $materialValues1 !!}
            </x-select> 
        @endif 
            
        @error($materialName1)
            <div class="alert alert-danger mt-1 text-red-700">{{ $message }}</div>
        @enderror
    </div>

    <div class="field lg:mr-4">
        <x-label class="mb-1 mt-4">
            {{ $materialLabel2 }}
        </x-label>
        @if($errors->has($materialName2)) 
            <x-select name="{{ $materialName2 }}" class="border-red-500">
                {!! $materialValues2 !!}
            </x-select>
        @else
            <x-select name="{{ $materialName2 }}">
                {!! $materialValues2 !!}
            </x-select> 
        @endif 
            
        @error($materialName2)
            <div class="alert alert-danger mt-1 text-red-700">{{ $message }}</div>
        @enderror
    </div>

    <div class="field">
        <x-label class="mb-1 mt-4">
            {{ $skillLevelLabel }}
        </x-label>
        @if($errors->has($skillLevelName))
            <x-input type="text" name="{{ $skillLevelName }}" :value="$skillLevelValue" class="border-red-500"></x-input>
        @else
            <x-input type="text" name="{{ $skillLevelName }}" :value="$skillLevelValue"></x-input>
        @endif
        @error($skillLevelName)
            <div class="alert alert-danger mt-1 text-red-700">{{ $message }}</div>
        @enderror
    </div>
    
    <br>
    <div class="w-full mt-8 flex justify-end">
        <x-button>
            Calculate
        </x-button>
    </div>
</form>