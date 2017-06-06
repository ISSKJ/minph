{include file='parts/header.tpl'}

<table class="table table-stripped panel">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Description</th>
    <th>Email</th>
    <th>Address</th>
    <th>Tel</th>
    <th>Updated</th>
    <th>Created</th>
</tr>
{foreach $hotels as $hotel}
<tr>
    <td>{$hotel.id}</td>
    <td>{$hotel.name}</td>
    <td>{$hotel.description}</td>
    <td>{$hotel.email}</td>
    <td>{$hotel.address}</td>
    <td>{$hotel.tel}</td>
    <td>{$hotel.updated|date_format:'r'}</td>
    <td>{$hotel.created|date_format:'r'}</td>
    <td><button class="button">Edit</button></td>
</tr>
{/foreach}
</table>


<nav aria-label="Page navigation">
    <ul class="pagination">
        {if $page.activePrev}
            <li>
                <a href="/hotels?page={$page.page-1}" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>
            </li>
        {else}
            <li class="disabled">
                <a href="/hotels?page=1" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>
            </li>
        {/if}

        {if $page.leftCollapse}
            {for $i=1 to 5}
                <li class="{if $i === $page.page}active{/if}"><a href="/hotels?page={$i}">{$i}</a></li>
            {/for}
        {else}
            {for $i=1 to 2}
                <li class="{if $i === $page.page}active{/if}"><a href="/hotels?page={$i}">{$i}</a></li>
            {/for}
            <li class="disabled"><a href="#">..</a></li>
        {/if}

        {if !$page.leftCollapse and !$page.rightCollapse}
            {for $i=$page.page-2 to $page.page+2}
                <li class="{if $i === $page.page}active{/if}"><a href="/hotels?page={$i}">{$i}</a></li>
            {/for}
        {/if}

        {if $page.rightCollapse}
            {for $i=$page.total-4 to $page.total}
                <li class="{if $i === $page.page}active{/if}"><a href="/hotels?page={$i}">{$i}</a></li>
            {/for}
        {else}
            <li class="disabled"><a href="#">..</a></li>
            {for $i=$page.total-1 to $page.total}
                <li class="{if $i === $page.page}active{/if}"><a href="/hotels?page={$i}">{$i}</a></li>
            {/for}
        {/if}

        {if $page.activeNext}
            <li>
                <a href="/hotels?page={$page.page+1}" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>
            </li>
        {else}
            <li class="disabled">
                <a href="/hotels?page={$page.total}" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>
            </li>
        {/if}
    </ul>
</nav>

{include file='parts/footer.tpl'}

