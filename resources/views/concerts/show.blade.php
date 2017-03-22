{{ $concert->title }}
{{ $concert->subtitle }}
{{ $concert->date->format('g:ia') }}
{{ $concert->formatted_date }}
{{ number_format($concert->ticket_price / 100, 2) }}
{{ $concert->venue }}
{{ $concert->venue_address }}
{{ $concert->city }}
{{ $concert->state }}
{{ $concert->zip }}
{{ $concert->additional_information }}
