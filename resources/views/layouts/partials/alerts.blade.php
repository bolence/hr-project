      @if( session()->has('success') )

                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <strong>Success!</strong> {{ session()->get('success') }}
                        </div>
                        
                    @endif


       @if( session()->has('danger') )

            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Success!</strong> {{ session()->get('danger') }}
            </div>
            
        @endif