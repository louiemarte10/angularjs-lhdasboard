SELECT 
d.*,
phone_num.phone as phone_num,
mobile_num.phone as mobile_num,
direct_line_num.phone as direct_line_num,
dda.linkedin_account_persona_id,
dda.date_added as contact_date_added,
dool.data_other_organization_lkp_id,
doh.organization_start,
doh.organization_end,
ot.organization_title,
c.date_connected,
c.connection_id,
del.data_email_lkp_id,
el.email,
el.status as email_status,
esl.source_name as email_source_name,
esl.x as email_source_status,
ol.*,
il.industry,
cl.country 
FROM `data` d 
LEFT OUTER JOIN `data_date_added` dda ON dda.data_id = d.data_id 
LEFT OUTER JOIN `data_other_organization_lkp` dool ON dool.data_id = d.data_id  AND dool.data_type = 'contact' AND dool.primary_organization = 1 
LEFT OUTER JOIN `data_organization_history` doh ON doh.data_other_organization_lkp_id = dool.data_other_organization_lkp_id 
LEFT OUTER JOIN `phone_numbers` phone_num ON phone_num.phone_number_id = d.phone_num_id 
LEFT OUTER JOIN `phone_numbers` mobile_num ON mobile_num.phone_number_id = d.mobile_num_id 
LEFT OUTER JOIN `phone_numbers` direct_line_num ON direct_line_num.phone_number_id = d.direct_line_num_id  
LEFT OUTER JOIN `organization_titles` ot ON ot.organization_title_id = dool.organization_title_id 
LEFT OUTER JOIN `connections` c ON c.data_id = d.data_id AND c.linked_account_persona_id = dda.linkedin_account_persona_id 
LEFT OUTER JOIN `data_email_lkp` del ON del.data_email_lkp_id = dool.data_email_lkp_id 
LEFT OUTER JOIN `emails_lkp` el ON el.email_id = del.email_lkp_id 
LEFT OUTER JOIN `email_src_lkp` esl ON esl.email_src_id = del.email_src_id 
LEFT OUTER JOIN `organizations_lkp` ol ON ol.organization_lkp_id = dool.organization_lkp_id 
LEFT OUTER JOIN `industries_lkp` il ON il.industry_lkp_id = ol.industry_lkp_id 
LEFT OUTER JOIN `countries_lkp` cl ON ol.country_id = cl.country_id 



