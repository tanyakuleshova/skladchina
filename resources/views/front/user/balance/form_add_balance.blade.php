<div class="panel">
    {!!trans('user_profile.addmoneyfor_text')!!}
    <div class="row">
      <div class="col-xxs col-xs-8">
        <form action="#" method="POST" id="form_add_balance">
          <div class="form-group">
            <label>{{trans('user_profile.insertsumm')}}</label>
            <input id="summa_user_add_balance" 
            type="number" 
            name="summa" 
            min="0" 
            class="form-control"
            placeholder="Введите сумму пополнения"
            required>
            <div class="form-group-button">
              <button type="submit" class="btn add_balance">Пополнить</button>
            </div>
          </div>
        </form>
      </div>
      <div class="col-xxs col-xs-4">
          <div class="balance-modal-icon">
            <img src="{{asset('images/front/visa.png')}}" alt="">
            <img src="{{asset('images/front/mastercard.png')}}" alt="">
        </div>
      </div>
    </div>
    
</div>
<script>
    $(document).on('click', '.add_balance', function (e) {
        e.preventDefault();
        var tforma = $(this.form);
        $.ajax({
            type: "POST",
            url: tforma.attr('action'),
            dataType: 'json',
            data: tforma.serialize(),
            success: function (msg) {
                console.log('msg => ',msg);
                if (msg.error !== undefined) {
                    swal('',msg.error, "error");
                }
                if (msg.forms !== undefined) {
                    $('body').append(msg.forms);
                    setTimeout(function(){
                        $('#form_for_pay_ik_other').click();
                    },30);

                }
            }
        });
    });
</script>



