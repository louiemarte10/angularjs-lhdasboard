/*jshint esversion: 11 */
/*jshint -W033 */

class Table {
   
   EOF_LINE = "\n";
   _node_id = 0;
   _table;
   _thead = [];
   _tfoot = [];
   _tr = [];
   attributes;
   border = 0;
   cellpadding = 3;
   cellspacing = 0;
   className;
   id;
   width;

   constructor(id = "") {
      this.id = id;
   }

   _formatAttributeClass(className = "") {
      return className ? ` class="${className}"`  : "";
   }

   _formatAttributes(attributes = "") {
      return attributes ? ` ${attributes}` : "";
   }

   _getNodeId() {
      return this._node_id;
   }

   _setNodeId() {         
      this._node_id++;
   }

   _getTbody() {
         let html = "";

         this._tr.forEach(tr => {
            html += `${tr}</tr>` + this.EOF_LINE;
         })
      
         return html;
   }

   _getThead() {
         let html = "";

         this._thead.forEach(thead => {
            html += `${thead}</thead>` + this.EOF_LINE;
         })

         return html;
   }

   _getTfoot() {
      let html = "";

      this._tfoot.forEach(tfoot => {
         html += `${tfoot}</tfoot>` + this.EOF_LINE;
      })

      return html;
   }

   td(text = "", className = "", attributes = "") {
         this._tr[this._getNodeId()] += `<td${this._formatAttributeClass(className)}${this._formatAttributes(attributes)}>
                ${text}</td>` + this.EOF_LINE;

         return this;
   }

   th(text = "", className = "", attributes = "") {
         
         this._thead[this._getNodeId()] += `<th${this._formatAttributeClass(className)}${this._formatAttributes(attributes)}>${text}</th>` + this.EOF_LINE;

         return this;
   }

   tf(text = "", className = "", attributes = "") {
         
      this._tfoot[this._getNodeId()] += `<td${this._formatAttributeClass(className)}${this._formatAttributes(attributes)}>
            ${text}</td>` + this.EOF_LINE;

      return $this;
   }

   thead(className = "", attributes = "") {
         
         this._setNodeId();

         this._thead[this._getNodeId()] = `<thead${this._formatAttributeClass(className)}${this._formatAttributes(attributes)}>`
               + this.EOF_LINE;

         return this;
   }

   tfoot(className = "", attributes = "") {
         
      this._setNodeId();

      this._tfoot[this._getNodeId()] = `<tfoot${this._formatAttributeClass(className)}${this._formatAttributes(attributes)}>`
            + this.EOF_LINE;

      return this;
   }

   tr(className = "", attributes = "") {
         
         this._setNodeId();
         
         this._tr[this._getNodeId()] = `<tr${this._formatAttributeClass(className)}${this._formatAttributes(attributes)}>`
               + this.EOF_LINE;

         return this;
   }

   getTable() {

      return `<table border="${this.border}"` +

            ( this.id ? ` id = "${this.id}"` : "" ) + this._formatAttributeClass(this.className) +
            this._formatAttributes(this.attributes) +

            ( this.width ? ` width="${this.width}"` : "" ) +

            ` cellpadding="${this.cellpadding}" cellspacing="${this.cellspacing}">` + this.EOF_LINE +

            this._getThead() + this._getTbody() + this._getTfoot() +

            /* this._table + */

            `</table>`;
   }
}