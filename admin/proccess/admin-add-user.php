<?php

echo " <div class='main-content-left'>
<form>
    <h2>Create a User</h2>
    <input type='text' placeholder='Enter username' id='user-name' required class='form-control'><br>
    <input type='email' placeholder='Enter user email' id='user-email' required class='form-control'><br>
    <input type='tel' placeholder='Enter user Mobile Number' id='user-number' required class='form-control'><br>
    <select class='form-control' id='role'>
        <option value='user'>User</option>
        <option value='admin'>Admin</option>
    </select><br>
    <input type='password' placeholder='Create default password' id='user-password' required class='form-control'><br>
    <button class='btn btn-primary' id='user-register'>Create a User</button>
</form>
</div>";