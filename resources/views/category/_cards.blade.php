@if(count($cards) > 0)
    @foreach ($cards as $card)
        <x-category-card 
            :title="$card->title" 
            :description="$card->description" 
            :questionnaireTitle="$card->questionnaireTitle"
            :categoryId="$card->categoryId" 
            :trainerId="$card->trainerId" 
            :trainerName="$card->trainerName"
            :questionnaireId="$card->questionnaireId"
            :passingGrade="$card->questionnairePassingGrade"
            :requestStatus="$card->requestStatus"
            :requestId="$card->requestId"
            :questionnaireTimeInterval="$card->questionnaireTimeInterval"
        />
    @endforeach
@else
    <p>No results found</p>
@endif
