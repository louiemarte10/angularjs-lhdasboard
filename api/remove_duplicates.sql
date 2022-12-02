DELETE FROM data_other_organization_lkp
 WHERE data_other_organization_lkp_id NOT IN (SELECT * 
                    FROM (SELECT MIN(dool.data_other_organization_lkp_id)
                            FROM data_other_organization_lkp dool
                        GROUP BY dool.data_id,dool.organization_lkp_id,dool.organization_title_id) x)