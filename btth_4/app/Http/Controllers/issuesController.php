<?php
namespace App\Http\Controllers;
use App\Models\computer;
use Illuminate\Http\Request;
use App\Models\issue;
use PHPUnit\TestRunner\TestResult\Issues\Issue as IssuesIssue;
class IssueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $issues = Issue::with('computer')->paginate(10);
        return view('issues.index', compact('issues'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $computers = computer::all(); // Lấy danh sách sinh viên để chọn
        return view('issues.create', compact('computers'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'computer_id'     => 'required|exists:computers,id',
            'reported_by'     => 'required|string|max:50',
            'reported_date'   => 'required|date',
            'description'     => 'required|string',
            'urgency'         => 'required|in:Low,Medium,High',
            'status'          => 'required|in:Open,In Progress,Resolved',
        ]);
        try {
            issue::create($request->all());
            return redirect()->route('issues.index')->with('success', 'Vấn đề được thêm thành công!');
        } catch (\Exception $e) {
            return redirect()->route('issues.index')->with('error', 'Có lỗi xảy ra khi thêm vấn đề!');
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $issue = issue::findOrFail($id);
        $computers = computer::all();
        $issue->reported_date = \Carbon\Carbon::parse($issue->reported_date);
        return view('issues.edit', compact('issue', 'computers'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'computer_id'     => 'required|exists:computers,id',
            'reported_by'     => 'required|string|max:50',
            'reported_date'   => 'required|date',
            'description'     => 'required|string',
            'urgency'         => 'required|in:Low,Medium,High',
            'status'          => 'required|in:Open,In Progress,Resolved',
        ]);
        try {
            $issue = issue::findOrFail($id);
            $issue->update($request->all());
            return redirect()->route('issues.index')->with('success', 'Vấn đề được cập nhật thành công!');
        } catch (\Exception $e) {
            return redirect()->route('issues.index')->with('error', 'Có lỗi xảy ra khi cập nhật vấn đề!');
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $issue = issue::findOrFail($id);
            $issue->delete();
            return redirect()->route('issues.index')->with('success', 'Vấn đề đã được xóa thành công!');
        } catch (\Exception $e) {
            return redirect()->route('issues.index')->with('error', 'Có lỗi xảy ra khi xóa vấn đề!');
        }
    }
}