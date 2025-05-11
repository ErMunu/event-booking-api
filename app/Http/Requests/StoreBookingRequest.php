<?php

namespace App\Http\Requests;

use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // No authentication required as per requirements
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'event_id' => [
                'required',
                'integer',
                Rule::exists('events', 'id'),
            ],
            'attendee_id' => [
                'required',
                'integer',
                Rule::exists('attendees', 'id'),
                function ($attribute, $value, $fail) {
                    $eventId = $this->input('event_id');
                    $attendee = Attendee::find($value);
                    
                    if ($attendee && $attendee->isBookedForEvent($eventId)) {
                        $fail('The attendee is already booked for this event.');
                    }
                },
            ],
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param \Illuminate\Validation\Validator $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $eventId = $this->input('event_id');
            $event = Event::find($eventId);
            
            if ($event && $event->isFullyBooked()) {
                $validator->errors()->add('event_id', 'The event is fully booked.');
            }
        });
    }
}