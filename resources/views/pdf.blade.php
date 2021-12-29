<p> Nome: {{$data[0]['user']['name']}}</p>

<h3>produtos</h3>
<ul>
    @foreach($data[1]['products'] as $product)
        <li>{{$product}}</li>
    @endforeach
</ul>
<p>data da compra: {{date('d/m/Y', strtotime($data[2]['pay']['buy_date']))}}</p>
<p>Valor da compra {{$data[2]['pay']['value']}}</p>
