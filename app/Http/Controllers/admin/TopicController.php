<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Topics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class TopicController extends Controller
{
    //

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'topic' => 'required|max:1024',
                'connection_id' => 'required|integer',
            ]);
            Topics::create($validatedData);
            // return redirect('/admin-panel')->with('success', 'New site has been added!');
            alert()->success('Success', 'New connection has been added!');
            return back();
        } catch (Throwable $e) {
            alert()->warning('Failed', "Add connection failed, " . $e->getMessage());
            return back();
        }
    }

    public function destroy(Topics $topic)
    {
        //
        try {
            // Topics::where('id', $topic->id)->delete();
            Topics::where('id', $topic->id)->update(['soft_delete' => 1]);

            alert()->success('Success', 'Delete topic success!');
            return back();
        } catch (Throwable $e) {
            alert()->warning('Failed', 'Delete topic failed, ' . $e->getMessage());
            return back();
        }
    }

    public function topic_list(Request $request)
    {
        $connection_id = $request->input('connection_id');
        // $columns = array(
        //     'dashboards.dashboard_name',
        //     'dashboards.description',
        //     'dashboards.created_at',
        //     'access_rights.id'
        // );
        // $collection = DB::table('access_rights')->select($columns)
        //     ->leftJoin('dashboards', 'access_rights.dashboard_id', '=', 'dashboards.id')->where('user_id', $user_id);
        $columns = array(
            'topic',
            'last_received',
            'created_at',
        );
        $collection = DB::table('topics')->where('connection_id', $connection_id);
        $totalData = $collection->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $table = $collection->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $totalFiltered = $collection->where(function ($query) use ($columns, $search) {
                foreach ($columns as $col) {
                    $query->orWhere($col, 'LIKE', "%{$search}%");
                }
                return $query;
            })->count();
            $table = $collection->where(function ($query) use ($columns, $search) {
                foreach ($columns as $col) {
                    $query->orWhere($col, 'LIKE', "%{$search}%");
                }
                return $query;
            })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        }

        $data = array();
        if (!empty($table)) {
            foreach ($table as $row) {
                $nestedData = [];
                $nestedData[] = $row->topic;
                $nestedData[] = $row->last_received;
                $nestedData[] = $row->created_at;
                // $nestedData[] = '<a href="/admin-panel/connection/' . $row->id . '"
                // class="font-weight-bold my-auto btn btn-dark">
                // Edit Connection
                // </a>';
                $nestedData[] = view('modal.delete_topic', ['topic_id' => $row->id, 'topic' => $row->topic])->render();
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );
        echo json_encode($json_data);
    }
}
