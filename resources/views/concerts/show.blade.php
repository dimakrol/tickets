{{ $concert->title }}
{{ $concert->subtitle }}
{{ (new Carbon\Carbon($concert->date))->format('g:ia') }}
{{ (new Carbon\Carbon($concert->date))->format('F j, Y') }}
{{ number_format($concert->ticket_price / 100, 2) }}
{{ $concert->venue }}
{{ $concert->venue_address }}
{{ $concert->city }}
{{ $concert->state }}
{{ $concert->zip }}
{{ $concert->additional_information }}
