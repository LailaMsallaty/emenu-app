<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->

<!-- Bootstrap -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}" ></script>


<!-- DataTables  & Plugins -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}" ></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>




<!-- AdminLTE -->
<script src="{{ asset('js/adminlte.js')}}"></script>

<!-- AdminLTE for demo purposes -->
<script src="{{ asset('js/demo.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>

<!-- Bootstrap Switch -->
<script src="{{ asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>
<!-- Page specific script -->
<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js')}}"></script>

<!-- plugins-jquery -->
 {{-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/jquery-ui-sortable@1.0.0/jquery-ui.min.js"></script>

<script>
$(document).ready(function(){
  var oTable = $('#MaterialUnit,#example2').dataTable();
  if($('#myInput').val() !== ''){
     oTable.fnFilter($('#myInput').val());
  }

}());
</script>
<script type="text/javascript">
 $(document).ready( function() {
//prevent form submit on refresh or resubmit with back button
if ( window.history.replaceState ) window.history.replaceState( null, null, window.location.href );
}
 );

</script>

<script>
 /////////////////////////////////////////////////////////////////////////////////////////////

 $(document).ready(function() {

        toastr.options.timeOut = 1000;
	    toastr.options.fadeOut = 1000;
        @if (Session::has('error'))
            toastr.error('{{ Session::get('error') }}');
        @elseif(Session::has('success'))
            toastr.success('{{ Session::get('success') }}');
        @endif

        $(document).on('click', '.checkAll', function() {
            if (this.checked) {
                $(".checkboxes").prop("checked", true);
            } else {
                $(".checkboxes").prop("checked", false);
            }
        });
       $(document).on('click', '.checkboxes,.checkAll', function() {
        var len = $(".checkboxes:checked").length;
                    if (len == 0) {
                        $(".delButton").prop("disabled", true);
                    } else {
                        // alert('ok');
                        $(".delButton").removeAttr("disabled");
                    }
        });

        $("#delButton").unbind("click").bind("click", function(e){
            e.preventDefault();
            if(confirm("Are you sure you want to delete?"))
            {
                var selected = new Array();
                $(".row_position input[type=checkbox]:checked").each(function() {
                    selected.push(this.value);
                });
                var url= $(this).data('url');
                var type='';
                var parent_id='';
                if ($('input[name=type]')) {
                    type = $('input[name=type]').val();
                }
                if ($('input[name=parent_id]')) {
                    parent_id = $('input[name=parent_id]').val();
                }
                $.ajax(
                {
                    headers: {
                                'X-CSRF-Token': '{{ csrf_token() }}',
                             },
                    url: url,
                    type:'POST',
                    data: {
                        "delete": selected,
                        "type":type,
                        "parent_id":parent_id,
                        "_method": 'POST'
                    },
                    success: function (data){
                    toastr.options.timeOut = 1500;
                    if (data.error) {
                        toastr.error(data.error);
                        console.log(data.message);
                    }else if(data.success){
                       // console.log(data);
                        $('#Container').load(data.url);
                        toastr.success(data.success);
                    }
                },
            });
            }else
            {
                return false;
            }
        });

        $("#example2").on("click",".deleteRecord", function(e){
        e.preventDefault();
        if(confirm("Are you sure you want to delete this record?"))
            {
                var id = $(this).data("id");
                var url= $(this).data('url');
                var type='';
                var parent_id='';
                if ($('input[name=type]')) {
                    type = $('input[name=type]').val();
                }
                if ($('input[name=parent_id]')) {
                    parent_id = $('input[name=parent_id]').val();
                }
                $.ajax(
                {
                    headers: {
                                'X-CSRF-Token': '{{ csrf_token() }}',
                             },
                    url: url,
                    type:'POST',
                    data: {
                        "id": id,
                        "type":type,
                        "parent_id":parent_id,
                        "_method": 'DELETE'
                    },
                    success: function (data){
                        toastr.options.timeOut = 1500;
                    if (data.error) {
                        toastr.error(data.error);
                        console.log(data.message);
                    }else if(data.success){
                        $('#Container').load(data.url);
                        toastr.success(data.success);
                    }
                    },
                });
            }
         });

        function imagepreview(input){

            if(input.files && input.files[0]) {

            var filerd = new FileReader();

            filerd.onload = function(e){

                $('#idForm + #imagepreview').remove();
                $('#imagepreview').attr('src',e.target.result);
            };

            filerd.readAsDataURL(input.files[0]);
            }

        }
        $('#idupload').change(function(){

            imagepreview(this);

            });


        const form = $(".repeater");
        const sortable = $(".sortable").sortable({
        update: function() {
            console.log(form.serializeArray());
        }
        });

        $('.deleteRow:first').hide();
        $(".repeater").repeater({
        show: function() {
            $(this).slideDown();
            $('.deleteRow:not(:first)').show();
            changeLang($("#langSelect").val());

        },
        hide: function(deleteElement) {
            $(this).slideUp(deleteElement);
        },
        ready: function(setIndexes) {
            sortable.on("sortchange", setIndexes);
        }
        });


        $(".arrow-up , .arrow-down").unbind("click").bind("click", function(e){
        e.preventDefault();
        var Catid =  $(this).data("id");
        var url = "{{ route('updateCategorySort') }}";
        var type;
        if ($('input[name=type]')) {
            type = $('input[name=type]').val();
        }
        var arrow='';
        arrow = ($(this).hasClass('arrow-down')) ?'down':'up';
        $.ajax({
            headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                    },
            url: url,
            type:'POST',
            data: {
                "id":Catid,
                "type":type,
                "arrow":arrow,
                "_method": 'POST'
            },
            success:function(data){
                    if (data.error) {
                    toastr.options.timeOut = 1500;
                    toastr.error(data.error);
                    console.log(data.message);
                }else{
                    $('#Container').load(data.url);
                }
            }
        })

        })

        $(".row_position").sortable({
            delay: 150,
            stop: function() {
                var selectedData = new Array();
                $('.row_position>tr').each(function() {
                    selectedData.push($(this).attr("id"));
                });
                updateOrder(selectedData);
            }
        });
        function updateOrder(data) {

            var url="{{ route('updateCategorySort') }}";
            $.ajax({
                headers: {
                        'X-CSRF-Token': '{{ csrf_token() }}',
                         },
                url:url,
                type:"POST",
                data:{
                    "position":data,
                    "_method": 'POST'
                },
                success:function(data){
                     if (data.error) {
                        toastr.options.timeOut = 1500;
                        toastr.error(data.error);
                        console.log(data.message);
                }
            }})
        }

        //editor
        $(function () {
        // Summernote
        $('.summernote').summernote()

    })

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })

    changeLang($("#langSelect").val());

    function changeLang(lang) {
        $('.langforms').each(function(){
		if($(this).data('id') == lang)
		{
			$(this).show(70);
		}
		else
		{
			$(this).hide(70);
		}
       });
    }

    $(document).on('change','#langSelect',function(){
		changeLang($("#langSelect").val());
	})

    $("#generatecode").unbind("click").bind("click", function(e){
        e.preventDefault();

		 var pathname=window.location.pathname;
		 var tblcodes=$("#tblcodes").val();
		 var tblcodesarray = tblcodes.trim().split('\n');
         var url = "{{ route('generateTables.codes', ":codes") }}";
             url = url.replace(':codes', tblcodesarray);
		 $.ajax({
			 url:url,
			 type : "GET",
			 success:function(data)
			 {
                if (data.error) {
                    console.log(data.message);
                }
                else{
                    var url=$.trim(data);
                    var urlarray=url.split('\n');
                    $("#tblurls").empty();
                    $.each(urlarray,function(i,value){
                        $("#tblurls").append(value);
                        $("#tblurls").append("\n");

                    })
                }
			 }
		 })
	 })
});
</script>
@if(App::getLocale()!=='ar')
<script>
     $(document).ready(function() {
        $(".bootstrap-switch").addClass("float-right");
     });
</script>
@else
<script>
    $(document).ready(function() {
       $(".bootstrap-switch").addClass("float-left");
    });
</script>
@endif
