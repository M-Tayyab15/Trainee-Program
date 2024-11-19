$(document).ready(function () {

    let pagewaliRows = 5;
    let currentpage = 1;
    const originalTable = $('#tableBody tr').clone();

    function displayTable(searchedRows) {
        const Rows = searchedRows || originalTable;
        const totalRows = Rows.length;
        const Pages = Math.ceil(totalRows / pagewaliRows);
        indexStart = (currentpage - 1) * pagewaliRows;
        indexEnd = (indexStart + pagewaliRows);

        $('#tableBody').empty().append(Rows.slice(indexStart, indexEnd));
        $('#pageNumbers').empty();
        for (let i = 1; i <= Pages; i++) {
            const pageNumber = $('<span>').text(i);
            pageNumber.addClass(i === currentpage ? 'active' : ' ');
            pageNumber.click(function () {
                currentpage = i;
                displayTable(searchedRows);
            });
            $('#pageNumbers').append(pageNumber);
        }
    }

    $('#entriesPerPage').change(function () {
        pagewaliRows = parseInt($(this).val());
        currentpage = 1;
        displayTable(originalTable);
    });


    $('#searchbar').on('keyup', function () {
        const value = $(this).val().toLowerCase();
        const searchedRows = originalTable.filter(function () {
            return $(this).text().toLowerCase().indexOf(value) > -1;
        });
        currentpage = 1;
        displayTable(searchedRows);
    });


    $('#resetButton').on('click',function()
    {
        $('#searchbar').val ('');
        currentpage = 1;
        displayTable(originalTable);
    });

    $('th').click(function()
    {
        //var table = $(this).parents('table').eq(0);
        var table = $(this).parents('table').eq(0);
        var rows = originalTable/*find('tr:gt(0)')*/.toArray().sort(comparer($(this).index()));
        this.asc = !this.asc;
        if (!this.asc)
        {
            rows = rows.reverse();
        }
        table.append(rows);
        currentpage = 1;
        displayTable(rows)
    }
);


    function comparer(index)
    {
        return function (a,b)
        {
            var ValA = getCellValue(a,index); 
            var ValB = getCellValue(b,index);
            return $.isNumeric(ValA) && $.isNumeric(ValB) ?
            ValA - ValB : ValA.toString().localeCompare(ValB);
        }
    }

    function getCellValue(row,index)
    {
        return $(row).children('td').eq(index).text();
    }

    displayTable(originalTable);
    }
);