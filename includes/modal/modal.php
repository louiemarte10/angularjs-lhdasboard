<div class="modal2" id="connection_modal" style="display: none;">
    <div class="modal-content2" id="connection_modal_content">
        <div class="modal-header2">
            <h2 id="modal-title">Insert New Report</h2>
            <span class="modal_close2">&times;</span>
        </div>
        <div class="column">
            <form id="connectionform" name="connectionform" action="get" role="form" class="ui form">
                <div class="field">
                    <div class="six wide field">
                        <label>Client</label>
						<?php echo $client_str_modal; ?>
                    </div>
                </div>
                <div class="fields">
                    <div class="four wide field">
                        <label for="from">Date</label>
                        <input id="from" name="from" placeholder="Date From" type="text"/>
                    </div>
                    <div class="four wide field">
                        <label>Client Account</label>
                        <select class="ui dropdown connection-fields" id="iclientaccount_modal" name="clientaccount">

                        </select>
                    </div>
                    <div class="four wide field">
                        <label>Persona</label>
						<?php echo $persona_str_modal; ?>
                    </div>
                    <div class="four wide field" style="margin-top: auto">
                        <button type="button" id="add_persona_new_modal" class="mini ui positive basic button"
                                style="width: 100%">ADD PERSONA
                        </button>
                    </div>
                </div>
                <div class="fields">
                    <div class="six wide field">
                        <label>Connection Invite Sent</label>
                        <input class="connection-fields con-num-fields" type="number" placeholder="Invite Sent"
                               id="invite_sent" name="invite_sent" value="0"/>
                    </div>
                    <div class="six wide field">
                        <label>Connection Accepted</label>
                        <input class="connection-fields con-num-fields" type="number" placeholder="Connections"
                               id="connections" name="connections" value="0"/>
                    </div>
                    <div class="six wide field">
                        <label>Direct Message Sent</label>
                        <input class="connection-fields con-num-fields" type="number" placeholder="Inmail Sent"
                               id="inmail_sent" name="inmail_sent" value="0"/>
                    </div>
                </div>
                <div class="fields">
                    <div class="six wide field">
                        <label>Groups</label>
                        <input class="connection-fields con-num-fields" type="number" placeholder="Groups" id="groups"
                               name="groups" value="0"/>
                    </div>
                    <div class="six wide field">
                        <label>Inmail Received <span id="info-span" title="Tags in TM outbound that were tagged under Social Media Channel starting March 29,2021 are already being counted in the Client Reports Social Media Reply Count.
If you still input a number here, it will add up on the Social Media Reply count shown in the Client Report and Campaign Report, so if you have religiously tagged replies in the TM Outbound, you can leave this  Inmails Received  field zero, to prevent doubling the reply count shown in the Client Reports.">i</span></label>
                        <input class="connection-fields con-num-fields" type="number" placeholder="Inmail Received"
                               id="inmail_received" name="inmail_received" value="0"/>
                    </div>
                    <div class="six wide field">
                        <label>Leads</label>
                        <input class="connection-fields con-num-fields" type="number" placeholder="Leads" id="leads"
                               name="leads" value="0"/>
                    </div>
                </div>
                <div class="field">
                    <div class="six wide field">
                        <button type="button" id="insertConnection" class="ui primary mini button"
                                style="margin: 0 90%; width: 86%">Insert
                        </button>
                    </div>
                </div>
<!--                <input type="hidden" value="0" name="inmail_sent">-->
<!--                <input type="hidden" value="0" name="inmail_received">-->
<!--                <input type="hidden" value="0" name="leads">-->
                <input type="hidden" value="0" name="discussions">
                <input type="hidden" value="0" name="social_media_id" id="social_media_id">
                <input type="hidden" value="false" name="is_generic" id="is_generic">
            </form>
        </div>
    </div>
</div>