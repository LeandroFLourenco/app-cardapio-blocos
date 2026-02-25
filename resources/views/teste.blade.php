<h1>Cardápio do Dia</h1>
<ul>
    @foreach($produtos as $produto)
        <li>{{ $produto }}</li>
    @endforeach
</ul>