<!DOCTYPE html>
<html>
<head>
    <title>My Task Manager</title>

    <link rel="stylesheet" href="/css/style.css?v=2">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

<div class="container">

    <!-- HEADER -->
    <div class="header">

        <div class="title-area">

            <div class="title-icon">
                ✓
            </div>

            <div>
                <h1>Task Manager</h1>
                <p>Small steps make big progress ♡</p>
            </div>

        </div>

        <div class="date-box">
            
            {{ now()->format('F d, Y') }}
            <br>
            {{ now()->format('g:i A') }}
        </div>

    </div>


 <!-- ADD TASK -->
<div class="add-task-box">

    <form action="/tasks" method="POST">

        @csrf


        <div class="input-group">

            <input
                type="text"
                name="task_name"
                placeholder="Enter your task here..."
                required
            >

            <input
                type="text"
                name="description"
                placeholder="Description"
            >

        </div>


        <div class="task-options">

            <!-- DUE DATE -->
            <div class="date-input">

                <label for="due_date">
                     Due Date
                </label>

                <input
                    type="date"
                    id="due_date"
                    name="due_date"
                >

            </div>


            <!-- STATUS -->
            <div class="status-input">

                <label for="status">
                     Status
                </label>

                <select
                    id="status"
                    name="status"
                >

                    <option value="Pending">
                        Pending
                    </option>

                    <option value="Ongoing">
                        Ongoing
                    </option>

                    <option value="Completed">
                        Completed
                    </option>

                </select>

            </div>

        </div>


        <button
            type="submit"
            class="add-task-button"
        >
            ➤ &nbsp; Add Task
        </button>

    </form>

</div>

    <!-- TASKS -->
    <div class="tasks-container">

        <div class="tasks-header">

            <div class="tasks-title">

                <span>☑</span>

                <h2>Your Tasks</h2>

            </div>

            <div class="task-count">
                {{ $tasks->count() }} tasks
            </div>

        </div>


        <!-- TASK LIST -->

        @foreach ($tasks as $task)

            @php
                $status = strtolower($task->status);
            @endphp

            <div class="task">

                <!-- CHECK CIRCLE -->

                <div class="check-circle
                    @if($status == 'completed')
                        completed
                    @endif
                ">

                    @if($status == 'completed')
                        ✓
                    @endif

                </div>


                <!-- TASK INFORMATION -->

                <div class="task-information">

                    <h3
                        @if($status == 'completed')
                            class="completed-text"
                        @endif
                    >
                        {{ $task->task_name }}
                    </h3>

                    @if($task->due_date)

                        <p class="due-date">
                            
                            {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}
                        </p>

                    @endif

                </div>


                <!-- STATUS -->

                <div class="status">

                    @if($status == 'pending')

                        <span class="pending">
                            Pending
                        </span>

                    @elseif($status == 'ongoing')

                        <span class="ongoing">
                            Ongoing
                        </span>

                    @elseif($status == 'completed')

                        <span class="completed">
                            Completed
                        </span>

                    @endif

                </div>


                <!-- ACTION BUTTONS -->

                <div class="actions">

                    <a
                        href="/tasks/{{ $task->id }}/edit"
                        class="edit-button"
                    >
                        ✎
                    </a>


                    <form
                        action="/tasks/{{ $task->id }}"
                        method="POST"
                    >

                        @csrf

                        @method('DELETE')

                        <button
                            type="submit"
                            class="delete-button"
                            onclick="return confirm('Are you sure you want to delete this task?')"
                        >
                            🗑
                        </button>

                    </form>

                </div>

            </div>

        @endforeach


        <!-- NO TASKS -->

        @if($tasks->count() == 0)

            <div class="no-tasks">

                <div>
                    📝
                </div>

                <h3>No tasks yet!</h3>

                <p>Add your first task above.</p>

            </div>

        @endif

    </div>

</div>


</body>
</html>