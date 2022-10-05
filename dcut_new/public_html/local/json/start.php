<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $.getJSON('/local/json/import.php',
        {
            IMPORT: {
                Body:{
                    Products:{
                        0:{
                            "GUID": "UUID(36 symbols)",
                            "IsGroup": false,
                            "Article_Number": "String 25",
                            "Code": "String 11",
                            "Name": "String 100",
                            "Full_Name": "String 1000",
                            "Description": "String not limited",
                            "Parent_GUID": "UUID(36 symbols)",
                            "Category_GUID": "UUID(36 symbols)"
                        },
                    }
                }
            }
        },
        function () {

        }
    );
</script>


