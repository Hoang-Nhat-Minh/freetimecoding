@extends('layout')

@section('content')
  {{-- @if (session('success'))
    <script>
      alert('{{ session('success') }}');
    </script>
  @endif --}}
  <div class="container m-0 px-5 pt-5">
    <a href="/alpine" class="btn btn-success">Alpine</a>
    <a href="/chat" class="btn btn-success">ChatBot</a>
    <a href="/chart" class="btn btn-success">Sơ đồ</a>
    <a href="/textimg" class="btn btn-success">Cool Text</a>
  </div>
  <form method="POST" action="{{ route('store') }}">
    @csrf

    <div class="contrainer p-5">
      <table class="table h-100">
        <thead>
          <tr class="text-center">
            <th scope="col">Tên</th>
            <th scope="col">Ảnh</th>
            <th scope="col">Chi tiết</th>
            <th scope="col">Giá</th>
            <th scope="col">Đặt hàng</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($items as $item)
            <tr class="text-center">
              <td>{{ $item->name }}</td>
              <td><img src="{{ Voyager::image($item->picture) }}" alt="{{ $item->name }}" width=75 height=75></td>
              <td>{{ $item->des }}</td>
              <td>{{ $item->price }}</td>
              <td>
                <div class="contrainer d-flex justify-content-center h-100">
                  <button type="button" class="btn btn-sm btn-success align-self-center min">-</button>
                  <input class="align-self-center m-2 quantity" name="{{ $item->name }}"
                    data-price="{{ $item->price }}" type="text" style="width:25px" value="0">
                  <button type="button" class="btn btn-sm btn-success align-self-center inc">+</button>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <ul class="pagination justify-content-center">
        {{ $items->links() }}
      </ul>
      <div class="container bg-secondary bg-gradient rounded p-4">
        <div class="mb-3">
          <label for="name" class="form-label">Nhập tên</label>
          <input type="text" class="form-control" id="name" name="name">
          @if ($errors->has('name'))
            <div class="alert alert-danger mt-1">{{ $errors->first('name') }}</div>
          @endif
        </div>
        <div class="mb-3">
          <label for="phone" class="form-label">Nhập số điện thoại</label>
          <input type="text" class="form-control" id="phone" name="phone">
          @if ($errors->has('phone'))
            <div class="alert alert-danger mt-1">{{ $errors->first('phone') }}</div>
          @endif
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" name="email">
          @if ($errors->has('email'))
            <div class="alert alert-danger mt-1">{{ $errors->first('email') }}</div>
          @endif
        </div>
        <div class="mb-3">
          <label for="note" class="form-label">Ghi chú</label>
          <input type="text" class="form-control" id="note" name="note">
        </div>
        <div class="container d-flex justify-content-end mt-3">
          @if ($errors->has('orders'))
            <div class="alert alert-danger m-2">{{ $errors->first('orders') }}</div>
          @endif
          <input type="hidden" name="orders">
          <input type="text" class="m-2" name="total" id="total" readonly>
          <button type="submit" class="btn btn-success m-2">Đặt hàng</button>
        </div>
      </div>
    </div>
  </form>
@endsection

@section('js')
  <script>
    let items = document.querySelectorAll('.quantity');

    for (let i = 0; i < items.length; i++) {
      let item = {
        name: items[i].name,
        quantity: items[i].value,
        price: items[i].getAttribute('data-price')
      }

      let incButton = items[i].parentNode.querySelector('.inc');
      let decButton = items[i].parentNode.querySelector('.min');

      incButton.addEventListener('click', function() {
        item.quantity++;
        items[i].value = item.quantity;
      });

      decButton.addEventListener('click', function() {
        if (item.quantity > 0) {
          item.quantity--;
          items[i].value = item.quantity;
        }
      });

      items[i].addEventListener('input', function() {
        let value = items[i].value;
        if (isNaN(value) || value < 0) {
          items[i].value = 0;
          item.quantity = 0;
        } else {
          item.quantity = value;
        }
      });

      function calculateTotal() {
        let total = 0;
        for (let i = 0; i < items.length; i++) {
          if (items[i].value >= 1) {
            total += parseInt(items[i].value) * items[i].getAttribute('data-price');
          }
        }
        document.getElementById('total').value = total;
      }

      function generateOrderString() {
        let orderString = '';
        for (let i = 0; i < items.length; i++) {
          if (items[i].value > 0) {
            orderString += items[i].name + '(' + items[i].value + '), ';
          }
        }

        orderString = orderString.slice(0, -2);
        document.querySelector('input[name="orders"]').value = orderString;
      }

      function handleInputChange() {
        calculateTotal();
        generateOrderString();
      }

      items[i].addEventListener('input', handleInputChange);
      items[i].parentNode.querySelector('.inc').addEventListener('click', handleInputChange);
      items[i].parentNode.querySelector('.min').addEventListener('click', handleInputChange);
    }
  </script>
@endsection


{{-- @php
  $img_br = \App\Banner::where('status', 'ACTIVE')->where('type', 'breadcrumb')->first();
@endphp
@extends('frontend.layouts.default')

@section('content')
  <main>
    @if (session('success'))
      <script>
        alert('{{ session('success') }}');
      </>
    @endif
    <!-- breadcrumb-about-area-start -->
    <div class="breadcrumb-about-area scene p-relative breadcrumb-bg">
      <div class="about-inner-shape">
        <div class="item">
          <img class="d-block h-50 w-100" src="{{ Voyager::image($img_br->image) }}" alt="{{ $img_br->title }}"
            loading="lazy">
        </div>
      </div>
    </div>
    <!-- seo-area-start -->
    <section class="portfolio-area mx-3 px-3" x-data="product">
      <section class="breadcrumb-area pb-20 pt-20">
        <div class="container-fluid">
          <div class="row">
            <div class="col-xxl-12">
              <div class="breadcrumb__content p-relative z-index-1">
                <h3 class="breadcrumb__title">ĐẶT HÀNG</h3>
                <div class="breadcrumb__list">
                  <span><a style="color:black;" href="{{ asset('/') }}">TRANG CHỦ</a></span>
                  <span class="dvdr"> / </span>
                  <span>ĐẶT HÀNG</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <form class="container-fluid" method="POST" action="{{ route('storeorders') }}" id="ordersForm">
        @csrf

        <div class="row">
          <table class="table table-reponsive m-auto col-md-6 col-sm-12">
            <tbody>
              <template x-for="(item, i) in data" :key='i'>
                <tr>
                  <div :class="item.type">
                    <td class="m-0 p-2" style="width: 150px;">
                      <a href="#" class="m-auto">
                        <img class="portfolio-inner-thumb img-fluid" :src="item.image"
                          class="img-fluid me-5 rounded-circle" loading="lazy" alt="item.title">
                      </a>
                    </td>
                    <td class="m-0 p-2">
                      <h5 class="portfolio-inner-title mb-0"
                        style="overflow: hidden;
                        text-overflow: ellipsis;
                        -webkit-line-clamp: 1;
                        display: -webkit-box;
                        -webkit-box-orient: vertical;">
                        <a href="#" style="color:black;" x-text="item.title"></a>
                      </h5>
                      <span
                        style="overflow: hidden;
                  text-overflow: ellipsis;
                  -webkit-line-clamp: 2;
                  display: -webkit-box;
                  -webkit-box-orient: vertical;"
                        x-text="item.description"></span>
                      <span style="font-weight: bold;" x-text="VND.format(item.price)"></span>
                    </td>
                    <td class="m-0 p-0 align-middle" style="width:90px;">
                      <div class="d-flex justify-content-between align-self-center">
                        <button type="button" class="btn btn-sm btn-warning p-auto m-auto" x-on:click="minus(i)"
                          style="width:30px">-</button>
                        <p class="text-center m-auto" x-text="item.quantity"></p>
                        <button type="button" class="btn btn-sm btn-warning p-auto m-auto" x-on:click="plus(i)"
                          style="width:30px">+</button>
                      </div>
                    </td>
                  </div>
                </tr>
              </template>
            </tbody>
          </table>
          <div class="col-md-6 col-sm-12">
            <h4>Nhập thông tin nhận</h4>
            <div class="mb-3">
              <label for="totalPrice" class="form-label">Tổng tiền của bạn</label>
              <span type="text" class="form-control" id="totalPrice" x-text="totalProducts()"></span>
              @error('orders')
                <div class="alert alert-danger mt-1">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="name" class="form-label">Họ tên</label>
              <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
              @error('name')
                <div class="alert alert-danger mt-1">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="telephone" class="form-label">Số điện thoại</label>
              <input type="text" class="form-control" id="telephone" name="telephone" value="{{ old('telephone') }}">
              @error('telephone')
                <div class="alert alert-danger mt-1">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="address" class="form-label">Địa chỉ</label>
              <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}">
              @error('address')
                <div class="alert alert-danger mt-1">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="note" class="form-label">Ghi chú</label>
              <textarea class="form-control" id="note" name="note" rows="4">{{ old('note') }}</textarea>
            </div>
            <input type="hidden" id="orders" name="orders">
            <input type="hidden" id="totalPrices" name="totalPrices" x-bind:value="totalProducts()">
            <button type="submit" class="btn btn-warning">Gửi</button>
          </div>
        </div>
      </form>
    </section>
    <!-- seo-area-end -->
  </main>
@endsection

@section('js')
  <script>
    let VND = new Intl.NumberFormat('vi-VN', {
      style: 'currency',
      currency: 'VND',
    });

    document.addEventListener('alpine:init', () => {
      Alpine.data('product', () => ({
        data: [],
        init() {
          let product = {!! json_encode($products) !!}
          let url_current = `{!! url('/') !!}`
          product.data.map((p) => {
            let id = p.id;
            let title = p.title;
            let slug = p.slug;
            let description = p.description;
            let image = url_current + '/storage/' + p.image;
            let type = p.type;
            let price = p.price;
            this.data.push({
              id,
              title,
              slug,
              description,
              image,
              type,
              price,
              quantity: 0
            })
          })
        },
        updateOrders() {
          let orders = this.data.filter(p => p.quantity > 0)
            .map(p => `${p.title}(${p.quantity})`).join(', ');

          document.getElementById('orders').value = orders;
        },
        minus(id) {
          if (this.data[id].quantity > 0) {
            this.data[id].quantity = this.data[id].quantity - 1;
            this.updateOrders();
          }
        },
        plus(id) {
          this.data[id].quantity = this.data[id].quantity + 1;
          this.updateOrders();
        },
        totalProducts() {
          let total = 0;
          this.data.map((p) => {
            let priceTotal = p.price * p.quantity;
            total += priceTotal;
          })

          return VND.format(total);
        }
      }))
    })
  </script>
@endsection --}}
