<h2>{trends_title}</h2>
<table class="table_trends">
{lanes}
    <tr>
        <td><h3>{lane}</h3></td>    
    </tr>
    <tr>
        <td><span class="table_content"><b><u>Name:</u></b></span></td>
        <td class="table_td_pickrate"><span class="table_content"><b><u>Pick rate:</u></b></span></td>
        <td class=><span class="table_content"><b><u>Ban rate:</u></b></span></td>
    </tr>
    {champions}
    <tr>
        <td><span class="table_content">{name}</span></td>
        <td class="table_td_pickrate"><span class="table_content">{pickrate}</span></td>
        <td class=><span class="table_content">{banrate}</span></td>
    </tr>
    {/champions}  
    <tr>
        <td><span class="table_content"><b><u>Most picked champion in this lane:</u></b></span></td>
    </tr>
    <tr>
        <td><span class="table_content"><b>{mostpicked}</b></span></td>
    </tr>
    <tr>
        <td><span class="table_content"><b><u>Most banned champion in this lane:</u></b></span></td>
    </tr>
    <tr>
        <td><span class="table_content"><b>{mostbanned}</b></span></td>
    </tr>   
    <!--
    {champions}
        <h5>{name}</h5
        <h5>{pickrate}</h5>
        <p>{banrate}</p>
    {/champions}
    -->
{/lanes}
    <tr>
        <td><h3>Most picked champion overall:</h3></td>    
    </tr>
    <tr>
        <td><span class="table_content"><b>{pickedoverall}</b></span></td>
    </tr>
    <tr>
        <td><h3>Most banned champion overall:</h3></td>    
    </tr>
    <tr>
        <td><span class="table_content"><b>{bannedoverall}</b></span></td>
    </tr>


</table>