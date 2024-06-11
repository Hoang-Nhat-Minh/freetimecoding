@extends('layout')

@section('content')
  <div class="container d-flex flex-col align-items-center" style="height:100vh">
    <h1>Biểu đồ thu nhập hàng tháng từ các sản phẩm</h1>
    <canvas id="productChart">

    </canvas>
  </div>
@endsection

@section('js')
  <script>
    const orders = JSON.parse('{!! $orders !!}');
    const counts = JSON.parse('{!! $counts !!}');
    const ctx = document.getElementById('productChart');

    console.log(orders);
    console.log(counts);
    const chart = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: orders,
        datasets: [{
          label: 'Số lượng đặt mua',
          data: counts,
          hoverOffset: 4
        }]
      },
    });
  </script>
@endsection
