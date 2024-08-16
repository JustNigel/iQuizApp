@if(count($cards) > 0)
    @foreach ($cards as $card)
        <x-category-card 
            title="{{ $card->title }}" 
            description="{!! $card->description !!}" 
            url="{{ $card->url }}" 
            buttonText="{{ $card->buttonText }}" 
        />
    @endforeach
@else
    <p>No results found</p>
@endif
