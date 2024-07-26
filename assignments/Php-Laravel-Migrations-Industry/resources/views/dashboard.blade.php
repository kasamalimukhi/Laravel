<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>


    {{-- @include('list',['pagename'=>"access to list page...",'val1'=>"dashboard"]) --}}
    {{-- @includeIf('list',['pagename'=>"dashboard"]) note: Includes a view only if it exists. No need to worry about missing view files. --}}
    {{-- @includeWhen(true,'list',['pagename'=>'dashboard'] )  Includes a view based on a given condition. Provides more dynamic control over the inclusion of views based on logic. --}}
    {{-- @includeUnless(true,'list',['pagename'=>'dashboard']) --}}
    <p>this is a dashboard</p>
    @php
        $cars = ['tata', 'maruti', 'mahindra', 'tesla'];
    @endphp

    {{-- for loop --}}
    @for ($i = 0; $i < count($cars); $i++)
        {{-- <p>{{$cars[$i]}}</p>         --}}
    @endfor

    {{-- foreach loop --}}
    @foreach ($cars as $items)
        {{-- <p>{{$items}}</p>  --}}
    @endforeach

    {{-- while loop --}}
    @php
        $count = 0;
    @endphp
    {{-- @while ($count <= 10) --}}
    {{-- <h3>{{$count++}}</h3> --}}
    @php

        // $count++;
    @endphp
    {{-- @endwhile --}}

    {{-- forelse loop --}}
    @php
        $items = ['burger', 'vadapau', 'dabeli', 'pakodi', 'bhel'];
        // $items = array();
    @endphp
    @forelse ($items as $item)
        {{-- <h4>{{$item}}</h4> --}}
    @empty
        {{-- <p>no items found</p> --}}
    @endforelse

    {{-- breke and continue statment --}}
    @php
        class User
        {
            public $type;
            public $name;
            public $number;

            public function __construct($type, $name, $number)
            {
                $this->type = $type;
                $this->name = $name;
                $this->number = $number;
            }
        }

        $users = [
            new User(0, 'Alice', 1),
            new User(1, 'Bob', 2),
            new User(0, 'Charlie', 3),
            new User(0, 'David', 4),
            new User(0, 'Eve', 5),
            new User(1, 'Frank', 6),
        ];
    @endphp

    @foreach ($users as $user)
        @if ($user->type == 1)
            @continue
        @endif

        <li>{{ $user->name }}</li>

        @if ($user->number == 5)
        @break
    @endif
@endforeach

        @php
            $i=1;
        @endphp
    @switch($i)
        @case(1)
            <p>case one</p>
            @break
        @case(2)
            <p>case two</p>
            @break
        @default
            <strong>not valide input</strong>
    @endswitch
</body>

</html>
