[.files[] | .file as $file | .failedTests[]? | "failed: \($file | ltrimstr($root)) › \(.test)"] as $failed
| [.files[] | .file as $file | .candidates[] | select(.action == "delete" or .action == "merge-into-dataset") | "\(.action): \($file | ltrimstr($root)) › \(.test)"] as $blocking
| ($failed + $blocking)[],
  "test-redundancy: \(.summary.testFiles) changed test file(s), \($blocking | length) delete / merge-into-dataset candidate(s), \(.summary.candidates - ($blocking | length)) other candidate(s); see \"composer test-redundancy -- --base=origin/master --format=text\".",
  if ($blocking | length) > 0 then
    "\($blocking | length) redundant test(s) in the changed test files. Apply each delete / merge-into-dataset candidate after checking it against its covering test, then run \"composer test-redundancy verify\".\n" | halt_error
  else empty end
