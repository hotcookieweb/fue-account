var boards = [
    {
        "id"    : "board-upcoming",               // id of the board
        "title" : "Upcoming",              // title of the board
        "class" : "",        // css classes to add at the title
        "dragTo": [],   // array of ids of boards where items can be dropped (default: [])
        "item"  : [                           // item of this board
            // {
            //     "id"    : "item-id-1",        // id of the item
            //     "title" : "Item 1"            // title of the item
            // },
        ]
    },
	{
        "id"    : "board-prepare-today",               // id of the board
        "title" : "Prepare Today",              // title of the board
        "class" : "",        // css classes to add at the title
        "dragTo": [],   // array of ids of boards where items can be dropped (default: [])
        "item"  : [                           // item of this board
            // {
            //     "id"    : "item-id-1",        // id of the item
            //     "title" : "Item 1"            // title of the item
            // },
        ]
    },
	{
        "id"    : "board-ship-today",               // id of the board
        "title" : "Ship Today",              // title of the board
        "class" : "",        // css classes to add at the title
        "dragTo": [],   // array of ids of boards where items can be dropped (default: [])
        "item"  : [                           // item of this board
            // {
            //     "id"    : "item-id-1",        // id of the item
            //     "title" : "Item 1"            // title of the item
            // },
        ]
    },
	{
        "id"    : "board-shipped",               // id of the board
        "title" : "Shipped",              // title of the board
        "class" : "",        // css classes to add at the title
        "dragTo": [],   // array of ids of boards where items can be dropped (default: [])
        "item"  : [                           // item of this board
            // {
            //     "id"    : "item-id-1",        // id of the item
            //     "title" : "Item 1"            // title of the item
            // },
        ]
    },
];

var kanban = new jKanban({
    element         : '#theboard',                                           // selector of the kanban container
    gutter          : '15px',                                       // gutter of the board
    widthBoard      : '250px',                                      // width of the board
    responsivePercentage: false,                                    // if it is true I use percentage in the width of the boards and it is not necessary gutter and widthBoard
    boards          : boards,                                           // json of boards
    dragBoards      : true,                                         // the boards are draggable, if false only item can be dragged
    addItemButton   : false,                                        // add a button to board for easy item creation
    buttonContent   : '+',                                          // text or html content of the board button
    click           : function (el) {},                             // callback when any board's item are clicked
    dragEl          : function (el, source) {},                     // callback when any board's item are dragged
    dragendEl       : function (el) {},                             // callback when any board's item stop drag
    dropEl          : function (el, target, source, sibling) {},    // callback when any board's item drop in a board
    dragBoard       : function (el, source) {},                     // callback when any board stop drag
    dragendBoard    : function (el) {},                             // callback when any board stop drag
    buttonClick     : function(el, boardId) {}                      // callback when the board's button is clicked
});
