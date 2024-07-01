<div class="col-lg-2 mb-4">
    <div class="sidebar">
        <a href="{{ route('course.announcements', ['course' => $course->id]) }}" class="{{ request()->routeIs('course.announcements') ? 'active' : '' }}">Announcements</a>
        <a href="{{ route('course.modules', ['course' => $course->id]) }}" class="{{ request()->routeIs('course.modules') ? 'active' : '' }}">Modules</a>
        <a href="{{ route('course.lecturersInfo', ['course' => $course->id]) }}" class="{{ request()->routeIs('course.lecturersInfo') ? 'active' : '' }}">Lecturer's Info</a>
        <a href="{{ route('courses.assignments', ['course' => $course->id]) }}" class="{{ request()->routeIs('course.assignments') ? 'active' : '' }}">Assignments</a>
        <a href="{{ route('course.attendance', ['course' => $course->id]) }}" class="{{ request()->routeIs('course.attendance') ? 'active' : '' }}">Attendance</a>
        <a href="{{ route('course.students', ['course' => $course->id]) }}" class="{{ request()->routeIs('course.students') ? 'active' : '' }}">Students</a>
    </div>
</div>
