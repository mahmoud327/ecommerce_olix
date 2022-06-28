<!-- Back-to-top -->
<a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>
<!-- JQuery min js -->
<script src="{{URL::asset('assets/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap Bundle js -->
<script src="{{URL::asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- Ionicons js -->
<script src="{{URL::asset('assets/plugins/ionicons/ionicons.js')}}"></script>
<!-- Moment js -->
<script src="{{URL::asset('assets/plugins/moment/moment.js')}}"></script>

<!-- Rating js-->
<script src="{{URL::asset('assets/plugins/rating/jquery.rating-stars.js')}}"></script>
<script src="{{URL::asset('assets/plugins/rating/jquery.barrating.js')}}"></script>

<!--Internal  Perfect-scrollbar js -->
<script src="{{URL::asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/perfect-scrollbar/p-scroll.js')}}"></script>
<!--Internal Sparkline js -->
<script src="{{URL::asset('assets/plugins/jquery-sparkline/jquery.sparkline.min.js')}}"></script>
<!-- Custom Scroll bar Js-->
<script src="{{URL::asset('assets/plugins/mscrollbar/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<!-- right-sidebar js -->
<script src="{{URL::asset('assets/plugins/sidebar/sidebar-rtl.js')}}"></script>
<script src="{{URL::asset('assets/plugins/sidebar/sidebar-custom.js')}}"></script>
<!-- Eva-icons js -->
<script src="{{URL::asset('assets/js/eva-icons.min.js')}}"></script>
@yield('js')
<!-- Sticky js -->
<script src="{{URL::asset('assets/js/sticky.js')}}"></script>
<!-- custom js -->
<script src="{{URL::asset('assets/js/custom.js')}}"></script><!-- Left-menu js-->
<script src="{{URL::asset('assets/plugins/side-menu/sidemenu.js')}}"></script>
<script src="{{asset('assets/assets/admin/js/dropzone.min.js')}}" type="text/javascript"></script>
@livewireScripts
<script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v0.x.x/dist/livewire-sortable.js"></script>

<script type="text/javascript">
    $( document ).ready(function() {
        setInterval(function(){

          $.ajax({

            url      : '{{url('admin/notification')}}',
            type     : 'get',
            success  : function (data) {
              if(data.status == 1)
              {
                 $( '#noti' ).empty();
                $.each(data.data, function(index,child)
                  {
                    if(child.content.ar === "product pennding")
                    {
                       $( '#noti').append(
                            '<a class="d-flex p-3 border-bottom" href="#">'+
                                '<div class="notifyimg bg-pink">'+
                                    '<i class="la la-file-alt text-white">'+
                                    '</i>'+
                                '</div>'+
                                '<div class="mr-3">'+
                                    '<h5 class="notification-label mb-1"> products</h5>'+
                                    '<div class="notification-subtext"></div>'+
                                '</div>'+

                                '</a>');
                    }

                });
                $( '#con' ).empty();
                $( '#con' ).append(data.data.length);

              }
            },
            error : function (jqXhr, textStatus, errorMessage){
            }

          });


        }, 10000);
      });
  </script>
@stack('script')
