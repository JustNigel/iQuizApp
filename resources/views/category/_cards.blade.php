@if(count($cards) > 0)
    <div class="flex justify-center">
        <div class="w-full max-w-6xl">
            <table class="min-w-full bg-gray-50 border border-gray-200 rounded-lg">
                <thead>
                    <tr class="bg-gray-100 border-b">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Category Title
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Trainer Name
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Questionnaire Title
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Passing Grade
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Time Interval
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Request Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($cards as $card)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $card->title }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $card->trainerName }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $card->questionnaireTitle }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $card->questionnairePassingGrade }}%
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $card->questionnaireTimeInterval }} mins
                            </td>
                            <td class="px-6 py-4 text-sm {{ $card->requestStatus == 'accepted' ? 'text-green-600' : 'text-yellow-600' }}">
                                {{ $card->requestStatus ? ucfirst($card->requestStatus) : 'Not Requested' }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @if($card->requestStatus == 'accepted')
                                    <!-- Request already accepted, hide button -->
                                    <span class="text-gray-400">Request Accepted</span>
                                @elseif($card->requestStatus && $card->requestId)
                                    <form action="{{ route('exam.request.cancel', $card->requestId) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700">Cancel</button>
                                    </form>
                                @else
                                    <form action="{{ route('exam.request.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="category_id" value="{{ $card->categoryId }}">
                                        <input type="hidden" name="trainer_id" value="{{ $card->trainerId }}">
                                        <input type="hidden" name="questionnaire_id" value="{{ $card->questionnaireId }}">
                                        <button type="submit" class="text-blue-500 hover:text-blue-700">Request to Join</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@else
    <p class="text-center">No results found</p>
@endif
