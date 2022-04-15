function onClickBtnActive(event){
    event.preventDefault();
    const icon= this.querySelector('i');
    const  class_=this;

    const active= this.closest("tr").querySelector('.active > .el');
    const points= this.closest("tr").querySelector('.active > .legend-indicator');
    console.log(points.classList);
    const url = this.href;
    //console.log(icon.classList.value);
    $.ajax({
        url:      url,
        type:       'get',
        dataType:   'json',
        success: function(response,status){

            if(class_.classList.contains('btn-outline-success')){
                class_.classList.replace('btn-outline-success','btn-outline-danger');

            }else{
                class_.classList.replace('btn-outline-danger','btn-outline-success');
            }

            /* if(class_.classList.contains('btn-light-success')){
                 class_.classList.replace('btn-light-danger','btn-light-success');
             }else{
                 class_.classList.replace('btn-light-success','btn-light-danger');
             }
 */
            if(icon.classList.contains('tio-stop-circle')){

                icon.classList.replace('tio-stop-circle','tio-checkmark-circle');
                class_.classList.replace('btn-outline-danger','btn-outline-success');
                points.classList.replace('bg-danger','bg-success');
            }
            else {

                icon.classList.replace('tio-checkmark-circle','tio-stop-circle');

                class_.classList.replace('btn-outline-success','btn-outline-danger');
                points.classList.replace('bg-success','bg-danger');
            }

            if(response.active==1){
                active.textContent="Activé";
                points.classList.replace('bg-danger','bg-success');
            }else{
                active.textContent="Désactivé";
                points.classList.replace('bg-success','bg-danger');
            }

        },
        error :function(error)
        {
            console.log(error);
        }
    });
}
document.querySelectorAll('a.activer').forEach(function (link) {
    link.addEventListener('click',onClickBtnActive);
})