page = PAGE
page.typeNum = 0
page.10 = FLUIDTEMPLATE
page.10 {
    format = html
    file = EXT:datavault/Resources/Private/Templates/Default.html
    layoutRootPaths {
        10 = EXT:datavault/Resources/Private/Layouts/
    }
    partialRootPaths {
        10 = EXT:datavault/Resources/Private/Partials/
    }
    templateRootPaths {
        10 = EXT:datavault/Resources/Private/Templates/
    }
}
page.includeJSFooter {
    jquery = //ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js
    jquery.external = 1
    main = EXT:datavault/Resources/Public/Js/main.js
}
page.includeCSS {
    main = EXT:datavault/Resources/Public/Css/styles.css
}
config {
    language = de
    spamProtectEmailAddresses = -2
    spamProtectEmailAddresses_atSubst = <span style="display:none;">dontospamme</span>@<wbr><span style="display:none;">gowaway.</span>
}
