//-------------------------------------------------
// Syntax highlighting
//-------------------------------------------------

var strReg1 = /"(.*?)"/g,
    strReg2 = /'(.*?)'/g,
    variablesReg = /([>]{1,1})([A-z0-9\-]{1,})/g,
    arrowReg = /([-]{1,1}[>]{1,1})/g,
    classReg = /(class[ ])([A-z0-9\-]{1,})|(new[ ])([A-z0-9\-]{1,})/g,
    specialReg = /\b(new|var|if|do|private|function|return|while|switch|for|foreach|in|continue|break)(?=[^\w])/g,
    specialJsGlobReg = /\b(document|window|Array|String|Object|Number|\$)(?=[^\w])/g,
    specialJsReg = /\b(getElementsBy(TagName|ClassName|Name)|getElementById|typeof|instanceof)(?=[^\w])/g,
    specialMethReg = /\b(indexOf|match|replace|toString|length)(?=[^\w])/g,
    specialPhpReg  = /\b(define|echo|print_r|var_dump)(?=[^\w])/g,
    functionMethodReg = /([A-z0-9\-]{1,}\()/g,
    variables2Reg = /((\$)[A-z0-9\-]{1,})/g,
    wrappersDotReg = /([\[\](){}.,;)])/g,
    specialCommentReg  = /(\/\*[\s\S]*?\*\/)/g,
    inlineCommentReg = /(\/\/.*)/g;

var htmlTagReg = /(&lt;[^\&]*&gt;)/g;

var sqlReg = /\b(CREATE|ALL|DATABASE|TABLE|GRANT|PRIVILEGES|IDENTIFIED|FLUSH|SELECT|UPDATE|DELETE|INSERT|FROM|WHERE|ORDER|BY|GROUP|LIMIT|INNER|OUTER|AS|ON|COUNT|CASE|TO|IF|WHEN|BETWEEN|AND|OR)(?=[^\w])/g;

var codeElements = $("pre");

codeElements.each(function (){

    var string = $(this).text(),
        parsed = string.replace(strReg1,"<span class=\"string\">\"$1\"</span>");
    parsed = parsed.replace(strReg2,"<span class=\"string\">'$1'</span>");
    parsed = parsed.replace(variablesReg, "$1<span class=\"variables\">$2</span>");
    parsed = parsed.replace(arrowReg, "<span class=\"wrappers_dot\">$1</span>");
    parsed = parsed.replace(classReg, "<span class=\"special\">$1$3</span><span class=\"classes\">$2$4</span>");
    parsed = parsed.replace(specialReg,"<span class=\"special\">$1</span>");
    parsed = parsed.replace(specialJsGlobReg,"<span class=\"special-js-glob\">$1</span>");
    parsed = parsed.replace(specialJsReg,"<span class=\"special-js\">$1</span>");
    parsed = parsed.replace(specialMethReg,"<span class=\"special-js-meth\">$1</span>");
    parsed = parsed.replace(htmlTagReg,"<span class=\"special-html\">$1</span>");
    parsed = parsed.replace(sqlReg,"<span class=\"special-sql\">$1</span>");
    parsed = parsed.replace(specialPhpReg,"<span class=\"special-php\">$1</span>");
    parsed = parsed.replace(functionMethodReg,"<span class=\"function-method\">$1</span>");
    parsed = parsed.replace(variables2Reg, "<span class=\"variables\">$1</span>");
    parsed = parsed.replace(wrappersDotReg, "<span class=\"wrappers_dot\">$1</span>");
    parsed = parsed.replace(specialCommentReg,function (result) {
        result = result.replace(/(<([^>]+)>)/ig, "");
        return "<span class=\"special-comment\">"+result+"</span>";

    });
    parsed = parsed.replace(inlineCommentReg,function (result) {

        result = result.replace(/(<([^>]+)>)/ig, "");
        return "<span class=\"special-comment\">"+result+"</span>";

    });

    this.innerHTML = parsed;
    
});

//-------------------------------------------------
// Add <code></code> for each new line
//-------------------------------------------------

$("pre").each( function() {
    var text = $(this)[0].innerHTML.split("\n");
    $(this).html("");
  
    for(var i = 0; i <  text.length; i++) {
        $(this).append( $("<code>").html( text[i] ) );
    }
  
});