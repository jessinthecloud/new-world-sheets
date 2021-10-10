<x-guest-layout>
    <section class="min-h-screen flex flex-col sm:justify-center items-left pt-6 sm:pt-0 bg-gray-100">
        <div class="mx-auto">
            <h2 class="font-bold text-2xl mb-8">{{ $title }}</h2>
            <x-calc-form
                :action="$action"
                
                :amountLabel="$amountLabel"
                :amountName="$amountName"
                :amountValue="$amountValue"
                
                :craftedItemLabel="$craftedItemLabel"
                :craftedItemName="$craftedItemName"
                :craftedItemValue="$craftedItemValue"
                
                :materialLabel1="$materialLabel1"
                :materialName1="$materialName1"
                :materialValues1="$materialValues1"
                
                :materialLabel2="$materialLabel2"
                :materialName2="$materialName2"
                :materialValues2="$materialValues2"
                
                :skillLevelLabel="$skillLevelLabel"
                :skillLevelName="$skillLevelName"
            ></x-calc-form>
        </div>
    </section>
</x-guest-layout>