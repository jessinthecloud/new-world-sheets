@props([
    'action',
    'amountLabel', 'amountName', 'amountValue',
    'craftedItemLabel', 'craftedItemName', 'craftedItemValue',
    'materialLabel1', 'materialName1', 'materialValues1',
    'materialLabel2', 'materialName2', 'materialValues2',
    'skillLevelLabel', 'skillLevelName'
])

<form action="{{ $action }}" method="POST">
    @csrf
    
{{--    @method()--}}
    
    <x-label class="mb-1 mt-4">
        {{ $amountLabel }}
    </x-label>
    <x-input type="text" name="{{ $amountName }}" :value="$amountValue" class=" {{--@error($amountName) border-red-500 @enderror--}} "/>
    @error($amountName)
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    
    <x-label class="mb-1 mt-4">
        {{ $craftedItemLabel }}
    </x-label>
    <x-select name="{{ $craftedItemName }}" class=" {{--@error($craftedItemName) border-red-500 @enderror--}} ">
        {!! $craftedItemValue !!}
    </x-select>
    @error($craftedItemName)
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <x-label class="mb-1 mt-4">
        {{ $materialLabel1 }}
    </x-label>
    <x-select name="{{ $materialName1 }}" class=" {{--@error($materialName1) border-red-500 @enderror--}} ">
        {!! $materialValues1 !!}
    </x-select>
    @error($materialName1)
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <x-label class="mb-1 mt-4">
        {{ $materialLabel2 }}
    </x-label>
    <x-select name="{{ $materialName2 }}" class=" {{--@error($materialName2) border-red-500 @enderror--}} ">
        {!! $materialValues2 !!}
    </x-select>
    @error($materialName2)
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <x-label class="mb-1 mt-4">
        {{ $skillLevelLabel }}
    </x-label>
    <x-input type="text" name="{{ $skillLevelName }}" :value="''" class=" {{--@error($skillLevelName) border-red-500 @enderror--}} "/>
    @error($skillLevelName)
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    
    <br>
    <x-button class="mt-8">
        Calculate
    </x-button>
</form>