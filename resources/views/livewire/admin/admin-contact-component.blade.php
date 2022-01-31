<div>
    <style>
        nav svg{
            height: 20px;
        }
        nav .hidden{
            display: block !important;
        }
    </style>
    <div class="container" style="padding:30px 0;">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                All Contacts Messages
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Comment</th>
                                <th>Date</th>

                            </tr>
                            <tbody>
                            @foreach($contacts as $contact)
                                <tr>
                                    <td>{{$contact->id}}</td>
                                    <td>{{$contact->name}}</td>
                                    <td>{{$contact->email}}</td>
                                    <td>{{$contact->phone}}</td>
                                    <td>{{$contact->comment}}</td>
                                    <td>{{$contact->created_at}}</td>

                                </tr>
                            @endforeach
                            </tbody>
                            </thead>
                        </table>
                        {{$contacts->links("pagination::bootstrap-4")}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
