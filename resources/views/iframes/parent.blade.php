@extends('layout')

@section('title', 'Parent Window')

@section('content')
<h1>The Parent Window</h1>
<div class="card">
    <div class="card-header">
        The messages sent to this window
    </div>
    <div class="card-body messages"></div>

    <div class="card-body iframecontent">
        <iframe src="/child" id="child" frameBorder="0" width="100%" height="500px" scrolling="no"></iframe>
    <div>
</div>
@endsection

@section('scripts')
    <script>
    // Get the iframe window
    var iframeWindow = $("#child")[0].contentWindow;

    function onLoad() {
        // Simulate a parent iframe behavior when receiving a message
        window.addEventListener("message", (event) => {
          var payload = null;
          for (var type in event.data) {
              payload = event.data;
          }

          if (null !== payload) {
              // Proxy the message to the parent window
              window.parent.postMessage(payload, "*");
              iframeWindow.postMessage(payload, "*");
          }

          payload = null;
        }, false);
    }
    </script>
@endsection
