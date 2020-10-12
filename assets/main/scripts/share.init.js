$("#share").jsSocials({
            shares: [
                {
                    share: "facebook",
                    logo: "mdi mdi-facebook text-light",
                    css: "custom-class",
                },
                {
                    share: "twitter",
                    logo: "mdi mdi-twitter text-light",
                    css: "custom-class",
                },
                {
                    share: "telegram",
                    logo: "mdi mdi-telegram text-light",
                    css: "custom-class",
                },
                {
                    share: "email",
                    logo: "mdi mdi-email-outline text-light",
                    css: "custom-class",
                },
                {
                    share: "whatsapp",
                    logo: "mdi mdi-whatsapp text-light",
                    css: "custom-class",
                }
                
            ],
            url: window.location.href,
            shareIn: "popup",
            showLabel: false,
        });