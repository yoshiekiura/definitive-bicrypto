<template>
    <div class="my-auto border-start border-end">
        <a
            class="nav-link nav-link-style fs-4 mx-1"
            style="padding-top: 0 !important; padding-bottom: 0 !important"
            @click="navStyle()"
        >
            <i class="bi bi-sun"></i>
        </a>
    </div>
</template>
<script>
export default {
    setup() {},
    methods: {
        getCurrentLayout() {
            var $html = $("html");
            var currentLayout = "";
            if ($html.hasClass("dark-layout")) {
                currentLayout = "dark-layout";
            } else if ($html.hasClass("bordered-layout")) {
                currentLayout = "bordered-layout";
            } else if ($html.hasClass("semi-dark-layout")) {
                currentLayout = "semi-dark-layout";
            } else {
                currentLayout = "light-layout";
            }
            return currentLayout;
        },
        navStyle() {
            var currentLayout = this.getCurrentLayout(),
                switchToLayout = "";
            // If currentLayout is not dark layout
            if (currentLayout !== "dark-layout") {
                // Switch to dark
                switchToLayout = "dark-layout";
            } else {
                switchToLayout = "light-layout";
            }

            // Call set layout
            this.setLayout(switchToLayout);

            // ToDo: Customizer fix
            $(".horizontal-menu .header-navbar.navbar-fixed").css({
                background: "inherit",
                "box-shadow": "inherit",
            });
            $(".horizontal-menu .horizontal-menu-wrapper.header-navbar").css(
                "background",
                "inherit"
            );
        },
        setLayout(currentLocalStorageLayout) {
            var $html = $("html");
            var navLinkStyle = $(".nav-link-style"),
                currentLayout = this.getCurrentLayout(),
                mainMenu = $(".main-menu"),
                navbar = $(".header-navbar"),
                // Witch to local storage layout if we have else current layout
                switchToLayout = currentLocalStorageLayout
                    ? currentLocalStorageLayout
                    : currentLayout;

            $html.removeClass("semi-dark-layout dark-layout bordered-layout");

            if (switchToLayout === "dark-layout") {
                $html.addClass("dark-layout");
                mainMenu.removeClass("menu-light").addClass("menu-dark");
                navbar.removeClass("navbar-light").addClass("navbar-dark");
                navLinkStyle
                    .find(".bi-moon")
                    .replaceWith('<i class="bi bi-sun"></i>');
            } else if (switchToLayout === "bordered-layout") {
                $html.addClass("bordered-layout");
                mainMenu.removeClass("menu-dark").addClass("menu-light");
                navbar.removeClass("navbar-dark").addClass("navbar-light");
                navLinkStyle
                    .find(".bi-sun")
                    .replaceWith('<i class="bi bi-moon"></i>');
            } else if (switchToLayout === "semi-dark-layout") {
                $html.addClass("semi-dark-layout");
                mainMenu.removeClass("menu-dark").addClass("menu-light");
                navbar.removeClass("navbar-dark").addClass("navbar-light");
                navLinkStyle
                    .find(".bi-sun")
                    .replaceWith('<i class="bi bi-moon"></i>');
            } else {
                $html.addClass("light-layout");
                mainMenu.removeClass("menu-dark").addClass("menu-light");
                navbar.removeClass("navbar-dark").addClass("navbar-light");
                navLinkStyle
                    .find(".bi-sun")
                    .replaceWith('<i class="bi bi-moon"></i>');
            }
            // Set radio in customizer if we have
            if (
                $("input:radio[data-layout=" + switchToLayout + "]").length > 0
            ) {
                setTimeout(function () {
                    $("input:radio[data-layout=" + switchToLayout + "]").prop(
                        "checked",
                        true
                    );
                });
            }
        },
    },
};
</script>
