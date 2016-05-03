// cliq.js
sessionStorage.clear();

/***************  Utility functions that have to be available at start  *****************************************************/

    /***
    * List functions here for descriptive purposes - 
    **/
    var Cliq = (function($) {
        
        // initialise
        // var shared values
        var cliqCfg = {
            useCaching: true,
            langcd: "en"
        }; 

        // Cliq.findOne('collection:help',{'reference':'$this.collection.name'})
        function getValue(tabletype, params) {
            var tm = explode(":", tabletype);
            var table = tm[0];
            var type = "";
            tm[1] ? type = tm[1] : type = "";
            return table+':'+type;
        }  

        /*
        function checkUnique(wid, fld, e) {
            
            var db = getRow(wid);
            var thisrecid = $("#"+wid+"_form input[name='recid']").val();
            if(thisrecid == 0) {
                var val = $("#"+wid+"_form input[name='"+fld+"']").val();
                var url = '/request/' + jlcd + '/isunique/' + db.clq_table + '/' + db.clq_tabletype + '/';
                var postdata = 'fld=' + fld + '&val=' + val;
                $.ajax({
                    url: url, data: postdata,
                    success: function(msg) {
                        // Test Ok or Not
                        var match = /Exists/.test(msg);
                        if (match == true) { 
                            useNoty({type: 'error', text:lstr[24]});
                            $("#"+wid+"_form input[name='"+fld+"']").val('').focus();
                            $.noty.closeAll();
                        } 
                    }, failure: function() {
                        useNoty({type: 'error', text:lstr[22]});
                    }
                });         
            }
            return false;       
        }

        function getNextRef(wid, fld, e) {
                            
            var db = getRow(wid); 
            var thisrecid = $("#"+wid+"_form input[name='recid']").val();
            console.log(thisrecid);
            if(thisrecid == 0) {
                var val = $("#"+wid+"_form input[name='"+fld+"']").val();
                var url = '/request/' + jlcd + '/getnextref/' + db.clq_table + '/' + db.clq_tabletype + '/';
                var postdata = 'fld=' + fld + '&defval=' + val;

                $.ajax({
                    url: url, data: postdata,
                    success: function(msg) {
                        // useNoty({text:msg});
                        $("#"+wid+"_form input[name='"+fld+"']").val(msg);
                        return false;
                    }, failure: function() {
                        useNoty({type: 'error', text:lstr[22]});
                    }
                });             
            }; return false;        
        }    
        */

        // explicitly return public methods when this object is instantiated
        return {
            findOne: getValue
        };

    })(jQuery); 

	function syntaxHighlight(json) {
	    if (typeof json != 'string') {
	         json = JSON.stringify(json, undefined, 2);
	    }
	    json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
	    return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
	        var cls = 'number';
	        if (/^"/.test(match)) {
	            if (/:$/.test(match)) {
	                cls = 'key';
	            } else {
	                cls = 'string';
	            }
	        } else if (/true|false/.test(match)) {
	            cls = 'boolean';
	        } else if (/null/.test(match)) {
	            cls = 'null';
	        }
	        return '<span class="' + cls + '">' + match + '</span>';
	    });
	}

