@extends('layout')

@section('head')
  <link rel="stylesheet" href="{{ asset('css/stylechat.css') }}">
@endsection

@section('content')
  <div class="container">
    <div class="row clearfix">
      <div class="col-lg-12">
        <div class="card chat-app">
          <div class="chat">
            <div class="chat-header clearfix">
              <div class="row">
                <div class="d-flex justify-content-between">
                  <img src="{{ asset('img/bt6vn7g2cXRUsjJn9E.gif') }}" style="height:50px;width:50px"
                    alt="bt6vn7g2cXRUsjJn9E" draggable = "false">
                  <img src="{{ asset('img/full.gif') }}" style="height:50px;width:50px" alt="full"
                    draggable = "false">
                  <img src="{{ asset('img/happy-chibi-anime-girl.gif') }}" style="height:50px;width:50px" alt="happy"
                    draggable = "false">
                  <img src="{{ asset('img/nezucon.gif') }}" style="height:50px;width:50px" alt="nezucon"
                    draggable = "false">
                  <img src="{{ asset('img/cute-anime-girl-3.gif') }}" style="height:50px;width:50px"
                    alt="cute-anime-girl-3" draggable = "false">
                  <img src="{{ asset('img/bt6vn7g2cXRUsjJn9E.gif') }}" style="height:50px;width:50px"
                    alt="bt6vn7g2cXRUsjJn9E" draggable = "false">
                  <img src="{{ asset('img/full.gif') }}" style="height:50px;width:50px" alt="full"
                    draggable = "false">
                  <img src="{{ asset('img/happy-chibi-anime-girl.gif') }}" style="height:50px;width:50px" alt="happy"
                    draggable = "false">
                  <img src="{{ asset('img/nezucon.gif') }}" style="height:50px;width:50px" alt="nezucon"
                    draggable = "false">
                  <img src="{{ asset('img/cute-anime-girl-3.gif') }}" style="height:50px;width:50px"
                    alt="cute-anime-girl-3" draggable = "false">
                </div>
              </div>
            </div>
            <div class="chat-history" style="background-image: linear-gradient(to right, #e9a4ea 0%, #8b7cff 100%);">
              <ul class="m-b-0">
                <li class="clearfix">
                  <div class="message my-message">Xin chào tôi có thể giúp gì cho bạn?</div>
                </li>
              </ul>
            </div>
            <div class="chat-message clearfix">
              <div class="input-group mb-0">
                <div class="input-group-prepend">
                  <button class="input-group-text" id="submitBtn">
                    <svg width="24" height="24" viewBox="0 0 512 512" style="color:currentColor"
                      xmlns="http://www.w3.org/2000/svg" class="h-full w-full">
                      <rect width="512" height="512" x="0" y="0" rx="30" fill="transparent"
                        stroke="transparent" stroke-width="0" stroke-opacity="100%" paint-order="stroke"></rect><svg
                        width="256px" height="256px" viewBox="0 0 24 24" fill="currentColor" x="128" y="128"
                        role="img" style="display:inline-block;vertical-align:middle"
                        xmlns="http://www.w3.org/2000/svg">
                        <g fill="currentColor">
                          <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2"
                            d="M9.912 12H4L2.023 4.135A.662.662 0 0 1 2 3.995c-.022-.721.772-1.221 1.46-.891L22 12L3.46 20.896c-.68.327-1.464-.159-1.46-.867a.66.66 0 0 1 .033-.186L3.5 15" />
                        </g>
                      </svg>
                    </svg></button>
                </div>
                <input type="text" id="userInput" class="form-control" placeholder="Nhập câu hỏi...">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script>
    window.onload = function() {
      const apiKey = "";
      const url = "https://api.openai.com/v1/chat/completions";

      let messageCount = 0;

      // Thêm sự kiện 'click' vào nút submit
      document.getElementById('submitBtn').addEventListener('click', sendMessage);

      // Thêm sự kiện 'keydown' vào ô nhập liệu
      document.getElementById('userInput').addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
          event.preventDefault();
          sendMessage();
        }
      });

      function sendMessage() {
        const userInput = document.getElementById('userInput').value;

        messageCount++;
        let now = new Date();
        let timeString = now.toLocaleTimeString();
        let dateString = now.toLocaleDateString();
        let fullString = `${timeString}, ${dateString}`;

        const botTypingElementId = `botTyping-${messageCount}`; // Tạo ID duy nhất

        // Thêm tin nhắn của người dùng vào lịch sử chat
        const userMessageElement = `
          <li class="clearfix">
            <div class="message-data text-right">
              <span class="message-data-time">${fullString}</span>
            </div>
            <div class="message other-message float-right">${userInput}</div>
          </li>
        `;
        document.querySelector('.chat-history ul').innerHTML += userMessageElement;

        document.getElementById('userInput').value = '';

        function typeMessage(message, elementId) {
          let i = 0;
          let speed = 30; // Thời gian giữa mỗi chữ cái (tính bằng mili giây)

          function typeWriter() {
            if (i < message.length) {
              document.getElementById(elementId).innerHTML += message.charAt(i);
              i++;
              setTimeout(typeWriter, speed);
            }
          }

          typeWriter();
        }

        // Hiển thị dấu "..." khi bot đang tìm kiếm câu trả lời
        const botTypingElement = `
          <li class="clearfix">
            <div class="message-data">
              <span class="message-data-time">${fullString}</span>
            </div>
            <div class="message my-message" id="${botTypingElementId}">
              <span class="dot">.</span>
              <span class="dot">.</span>
              <span class="dot">.</span>
            </div>
          </li>
        `;
        document.querySelector('.chat-history ul').innerHTML += botTypingElement;

        fetch(url, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${apiKey}`
          },
          body: JSON.stringify({
            'model': 'gpt-3.5-turbo',
            'messages': [{
              "role": "user",
              "content": userInput
            }],
          })
        }).then(response => response.json()).then(data => {
          const botResponse = data.choices[0].message.content;
          console.log(data);

          //Đưa nội dung về trống
          document.getElementById(botTypingElementId).innerText = '';

          // Gọi hàm typeMessage thay vì cập nhật nội dung của phần tử ngay lập tức
          typeMessage(botResponse, botTypingElementId);
        });

        let chatHistory = document.querySelector('.chat-history');
        chatHistory.scrollTop = chatHistory.scrollHeight;
      }
    }
  </script>
