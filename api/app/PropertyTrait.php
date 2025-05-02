<?php

namespace App;

trait PropertyTrait
{
    public function getPropertyProgress($request){
        $progress = [
            [
                'stage' => 'Creation',
                'completed' => true,
                'details' => 'Request created on ' . $request->date_requested,
            ],
        ];
    
        // if ptr is not yet pc approved
        if($request->pc_request_approved === null){
            $progress[] = [
                [
                    'stage' => 'Approval',
                    'completed' => false,
                    'details' => 'Awaiting Approval of Property Custodian',
                ],
            ];
        }

        // if ptr is pc approved
        if($request->pc_request_approved === 1){
            $progress[] = [
                [
                    'stage' => 'Approval of Property Custodian',
                    'completed' => true,
                    'details' => 'Approved by Property Custodian on ' . $request->pc_request_approved_date,
                ],
            ];
        }

         // if ptr is pc rejected
         if($request->pc_request_approved === 0){
            $progress[] = [
                [
                    'stage' => 'Approval of Property Custodian',
                    'completed' => true,
                    'details' => 'Rejected by Property Custodian on ' . $request->pc_request_approved_date . ' with reason: ' . $request->pc_request_rejection_reason,
                ],
            ];
        }
    

         // if ptr is not yet dc approved
         if($request->approved_by === null){
            $progress[] = [
                [
                    'stage' => 'Approval of MSD Division Chief',
                    'completed' => false,
                    'details' => 'Awaiting Approval of MSD Division Chief',
                ],
            ];
        }

        // if ptr is dc approved
        if($request->approved_by === 1){
            $progress[] = [
                [
                    'stage' => 'Approval of MSD Division Chief',
                    'completed' => true,
                    'details' => 'Approved by MSD Division Chief on ' . $request->approved_date,
                ],
            ];
        }

         // if ptr is dc rejected
         if($request->approved_by === 0){
            $progress[] = [
                [
                    'stage' => 'Approval of MSD Division Chief',
                    'completed' => true,
                    'details' => 'Rejected by MSD Division Chief on ' . $request->approved_date ,
                ],
            ];
        }
    
        return $progress;
    }
}
