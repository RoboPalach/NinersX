// Most options demonstrate the non-default behavior
var simplemde = new SimpleMDE({
    autofocus: true,
    blockStyles: {
        bold: "__",
        italic: "_"
    },
    element: document.getElementById("cContent"),
    previewClass: ["editor-preview", "img{width:100px}"],
    hideIcons: ["guide", "heading"],
    indentWithTabs: false,
    initialValue: "Hello world!",
    insertTexts: {
        horizontalRule: ["", "\n\n-----\n\n"],
        image: ["![](http://", ")"],
        link: ["[", "](http://)"],
        table: ["", "\n\n| Column 1 | Column 2 | Column 3 |\n| -------- | -------- | -------- |\n| Text     | Text      | Text     |\n\n"],
    },
    lineWrapping: false,
    showIcons: ["code", "table"],
    status: ["autosave", "lines", "words", "cursor"], // Optional usage
    styleSelectedText: false,
    tabSize: 4,
    toolbar:[
        'heading-smaller','bold','italic','strikethrough','|',
        'code','quote','unordered-list','ordered-list','|',
        'horizontal-rule','table','link',{
            name: "image",
            className: "fa fa-image",
            action: ()=>{
                $('#imageSelectorModal').modal('show')
            }
        },'|',
        'preview','side-by-side','fullscreen',{
            name:"Help",
            className: "fa fa-question",
            action:()=>{
                window.open("https://simplemde.com/markdown-guide",'_blank')
            }
        }
    ]
});
$('[title="Toggle Side by Side (F9)"]').click(()=>{
    if(!$('nav').hasClass("d-none"))
        $("nav").toggleClass("d-none");
})

$('[title="Toggle Fullscreen (F11)"]').click(()=>{
    $("nav").toggleClass("d-none");
})
$('#cSaveBtn').click((e)=>{
    const btn = $(e.target)
    let formData = new FormData()
});
