<h1>User Maintenance</h1>
<div>
    <table class="table">
        <tr>
            <th>Action</th>
            <th>Userid</th>
            <th>Role</th>
            <th>Name</th>
            <th>Status</th>
        </tr>
        {users}
        <tr>
            <td>
                <a href="/blog/usermtce/edit/{id}"><i>EDIT</i></a>
                <a href="/blog/usermtce/delete/{id}"><i>DEL</i></a>
            </td>
            <!--
            <td><a class="btn btn-mini" href="/usermtce/edit/{id}"><i  class="icon-edit"></i></a>
                <a class="btn btn-mini" href="/usermtce/delete/{id}"><i  class="icon-trash"></i></a></td>
            -->
            <td>{id}</td>
            <td>{role}</td>
            <td>{name}</td>
            <td>{status}</td>
        </tr>
        {/users}
    </table>
</div>
<div>
    <a href="/blog/usermtce/add">Add a new user</a>
</div>