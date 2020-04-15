$(document).ready(function () {

    $('input').click(function (event) {
        this.select()
    })

    $('button').click(function (event) {
        let id = $(this).attr('id')
        switch (id) {
            case 'submit':
                validate()
                break
            case 'clear':
                $('#inn').val('')
                break
        }
    })

    function validate() {
        $.post('./asset/php/work.php', {
            'inn': $('#inn').val()
        }).done(function (data) {
            let res = JSON.parse(data)
            if (res.err_msg != null){
                $('#err').removeClass('d-none')
                $('#err_msg').text(res.err_msg)
                setTimeout(()=>{
                    $('#err').addClass('d-none')
                    $('#err_msg').text('')
                }, 7000)
            } else {
                let respond = JSON.parse(res.result)
                // console.log(respond.status) //undefined
                // console.log(respond.message)
                // console.log(respond.code) //undefined
                if (respond.status != undefined) {
                    $('#msg').removeClass('d-none')
                    $('#res_msg').text(respond.message)
                    setTimeout(()=>{
                        $('#msg').addClass('d-none')
                        $('#res_msg').text('')
                    }, 7000)
                } else {
                    $('#err').removeClass('d-none')
                    $('#err_msg').html(respond.message + '<br>' + 'code: ' + respond.code)
                    setTimeout(()=>{
                        $('#err').addClass('d-none')
                        $('#err_msg').text('')
                    }, 7000)
                }
            }
        })
    }

})
