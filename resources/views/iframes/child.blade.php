@extends('layout')

@section('content')

    <div class="card">
        <div class="card-body">
            <form id="postmessagedemoform1">
              <div class="form-group">
                <label for="exampleFormControlInput1">Subject</label>
                <input type="text" class="form-control" name="subject" id="exampleFormControlInput1" placeholder="The message subject">
              </div>

              <div class="form-group">
                <label for="exampleFormControlTextarea1">Body</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="The body of the message"></textarea>
              </div>

              <button type="submit" class="btn btn-primary">Send</button>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
    function onLoad() {
        window.addEventListener("message", (event) => {
          for (var type in event.data) {
              var payload = event.data[type];

              if (type === "token") {
                  sessionStorage.setItem('token', payload);
              }
          }
        }, false);

        window.parent.postMessage({
            "action": "InitiateHandshake",
        }, "*");
    }

    $("#postmessagedemoform1").on('submit', function(e) {
        e.preventDefault();
        var $form = $(this);

        window.parent.postMessage({
            action: "OpenExternalWindow",
            args: [$form.find("#exampleFormControlInput1").val(), $form.find("#exampleFormControlTextarea1").val()],
            token: sessionStorage.getItem("token"),
        });
    });
    </script>
@endsection
