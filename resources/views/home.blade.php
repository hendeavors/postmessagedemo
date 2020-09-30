@extends('layout')

@section('title', 'Home Window')

@section('content')
<h1>The Home Page</h1>

<div class="card">
    <div class="card-header">
        The messages sent to this window
    </div>
    <div class="card-body messages"></div>

    <div class="card-body iframecontent">
        <iframe src="/parent" id="parent" frameBorder="0" width="100%" height="500px" scrolling="no"></iframe>
    <div>
</div>
@endsection

@section('scripts')
    <script>
    // Get the iframe window
    var iframeWindow = $("#parent")[0].contentWindow;

    function onLoad() {
        // Simulate a client receiving postMessage
        window.addEventListener("message", (event) => {
          var proxyAction = null;
          var proxyActionValues = null;
          var proxyActionTokenValue = null;
          for (var type in event.data) {
              var payload = event.data[type];

              if (type === "action") {
                  proxyAction = payload;
              } else if (type === "args") {
                  proxyActionValues = payload;
              } else if (type === "token") {
                  proxyActionTokenValue = payload;
              }
          }

          if (proxyAction === "InitiateHandshake") {
              iframeWindow.postMessage({
                  "token": Math.random()
              }, "*");
          }

          if (proxyAction === "OpenExternalWindow" && proxyActionTokenValue !== null) {
              $('.card-body.messages').append('<p>' + proxyActionValues + '</p>');
          }
        }, false);
    }
    </script>
@endsection
