<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\{User, Course};
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Enums\UserRole;

class AddCourseApiTest extends TestCase
{
    use RefreshDatabase;

    private $course_url;
    private $title;
    private $student;
    private $course;
    private $link;
    private $lecturer;

    public function setUp(): void
    {
        parent::setUp();
        $this->title = 'Test title for manual testing';
        $this->course_url = route('create.course');

        $this->lecturer = \App\Models\User::factory()->create([
            'role' => UserRole::LECTURER
        ]);
        $this->course = \App\Models\Course::factory()->create([
            'author_id' => $this->lecturer->id
        ]);
        $this->student = \App\Models\User::factory()->create([
            'role' => UserRole::STUDENT
        ]);
    }

    public function test_create_course()
    {
        $this->actingAs($this->lecturer);
        $response = $this->postJson($this->course_url, [
            'title' => $this->title,
            'user_id' => [$this->student->id],
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonFragment(['title' => $this->title]);
    }

    public function test_student_create_course()
    {
        $this->actingAs($this->student);
        $response = $this->postJson($this->course_url, [
            'title' => $this->title,
            'user_id' => [$this->student->id],
        ]);

        $response
            ->assertJsonFragment(['error' => __('authorize.forbidden_by_role')])
            ->assertStatus(400);
    }

    public function test_unauthorized_create_course()
    {
        $response = $this->postJson($this->course_url);

        $response
            ->assertJsonFragment(['error' => __('authorize.unauthorized')])
            ->assertStatus(400);
    }

    public function test_create_course_with_empty_users()
    {
        $this->actingAs($this->lecturer);
        $response = $this->postJson($this->course_url, [
            'title' => $this->title,
            'user_id' => '',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonFragment([
                'errors' => [
                    'user_id' => [
                        __('validation.required', ['attribute' => 'user id'])
                    ]
                ]
            ]);
    }

}
