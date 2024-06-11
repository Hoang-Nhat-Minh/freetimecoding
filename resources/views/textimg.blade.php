@extends('layout')

@section('head')
  <style>
    body {
      background-color: black;
    }

    .container-fluid {
      height: 100vh;
      width: 100vw;
      position: relative;
    }

    .border {
      position: absolute;
      z-index: -1;
      border: 10px solid plum;
      border-radius: 20px;
      animation: bounce 5s infinite ease;
    }

    @keyframes bounce {
      0% {
        transform: translate(-100%, -100%) translate3d(0, 0, 0)
      }

      25% {
        transform: translate(-100%, -100%) translate3d(100%, 0, 0)
      }

      50% {
        transform: translate(-100%, -100%) translate3d(100%, 100%, 0)
      }

      75% {
        transform: translate(-100%, -100%) translate3d(0, 100%, 0)
      }

      100% {
        transform: translate(-100%, -100%) translate3d(0, 0, 0)
      }
    }

    p {
      font-size: clamp(1em, 40vw + 1em, 8em);
      background-size: cover;
      background-clip: text;
      -webkit-background-clip: text;
      color: transparent;
      background-image: url('/img/bg.jpg');
    }
  </style>
@endsection

@section('content')
  <div class="container-fluid">
    <p class="m-0 p-0">HELLO WORLD</p>
    <div class="border"></div>
  </div>
@endsection
