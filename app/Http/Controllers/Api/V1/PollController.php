<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;
use App\Poll;
use App\PollOption;
use App\Vote;
use App\Partner;
use App\Team;
use App\Helpers\ApiHelper;
use TCG\Voyager\Facades\Voyager;
class PollController extends VoyagerBaseController
{
    //


    public function store(Request $request)
    {
        // Begin transaction
        \DB::beginTransaction();

        try {
            // Create the Poll
            $poll = new Poll;
            $poll->question = $request->question;
            $poll->status = $request->status;
            $poll->save();

            // Ensure $request->options is a string and then split it
            $optionsInput = $request->options;

            // Check if the input is an array, and convert it to a string if necessary
            if (is_array($optionsInput)) {
                $optionsInput = implode(',', $optionsInput); // Convert array back to a comma-separated string
            }

            $options = explode(',', $optionsInput); // Now, it's safe to assume $optionsInput is a string

            foreach ($options as $optionText) {
                $option = new PollOption;
                $option->poll_id = $poll->id;
                $option->text = trim($optionText);
                $option->save();
            }

            // Commit transaction
            \DB::commit();
            return redirect()->route('voyager.polls.index')
                ->with(['message' => 'Successfully created poll and options', 'alert-type' => 'success']);
        } catch (\Exception $e) {
            // Rollback transaction
            \DB::rollBack();
            return redirect()->route('voyager.polls.index')
                ->with(['message' => 'Failed to create poll and options', 'alert-type' => 'error']);
        }
    }



    public function edit(Request $request, $id)
    {
        // Assuming 'polls' is the slug for your DataType
        $dataType = \TCG\Voyager\Facades\Voyager::model('DataType')->where('slug', '=', 'polls')->first();

        $dataTypeContent = Poll::with('options')->findOrFail($id);
        $poll = Poll::with('options')->findOrFail($id);
        // Check if the model is translatable
        $isModelTranslatable = is_bread_translatable($dataTypeContent);

        return view('voyager::polls.edit-add', compact('dataType', 'dataTypeContent', 'isModelTranslatable', 'poll'));
    }


    public function update(Request $request, $id)
    {
        \DB::beginTransaction();

        try {
            $poll = Poll::findOrFail($id);
            $poll->question = $request->question;
            $poll->status = $request->status;
            $poll->save();

            // Delete all existing options and recreate them
            PollOption::where('poll_id', $poll->id)->delete();

            // Check if options are sent as an array or a comma-separated string
            if (is_array($request->options)) {
                $options = $request->options;
            } else {
                $options = explode(',', $request->options);
            }

            foreach ($options as $optionText) {
                $option = new PollOption;
                $option->poll_id = $poll->id;
                $option->text = trim($optionText);
                $option->save();
            }

            \DB::commit();
            return redirect()->route('voyager.polls.index')
                ->with(['message' => 'Successfully updated poll and options', 'alert-type' => 'success']);
        } catch (\Exception $e) {
            \DB::rollBack();
            return redirect()->route('voyager.polls.index')
                ->with(['message' => 'Failed to update poll and options', 'alert-type' => 'error']);
        }
    }


    public function listPolls(Request $request)
    {
        $polls = Poll::with('options')
            ->where('status', 'PUBLISHED')
            ->get();


        $result = ApiHelper::success('polls',$polls );

		return response()->json($result, 200);

    }
    public function partners(Request $request)
    {
        $polls = Partner::where('status', 'PUBLISHED')
            ->get();


        $result = ApiHelper::success('partners',$polls );

		return response()->json($result, 200);

    }
    public function teams(Request $request)
    {
        $teams = Team::where('status', 'PUBLISHED')
            ->get();


        $result = ApiHelper::success('teams',$teams );

		return response()->json($result, 200);

    }


    public function vote(Request $request, $optionId)
    {
        // $request->validate([
        //     'email' => 'required|email'  // Validate email if it's required; adjust accordingly
        // ]);

        $option = PollOption::findOrFail($optionId);

        // return($option);
        // Prevent multiple votes from the same IP for the same option
        if ($option->votes()->where('voter_ip', $request->ip())->exists()) {
            $result = ApiHelper::successMessage('You have already voted.');
            return response()->json($result, 200);
        }

        $vote = new Vote;
        $vote->option_id = $optionId;
        $vote->voter_ip = $request->ip();
        $vote->voter_contact = $request->voter_contact;  // Store the email provided
        $vote->save();


        $result = ApiHelper::success('Thank you for voting!', $vote);

		return response()->json($result, 200);
        
    }





}
