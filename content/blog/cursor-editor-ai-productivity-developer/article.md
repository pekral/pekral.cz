---
date: 2026-03-09
description: How I use Cursor editor, AI models like Claude and Codex, and custom Cursor skills to automate code review, testing, and refactoring — and how it boosted my productivity by about 50%.
---

# Cursor Editor for developers: how AI increased my productivity by 50%

AI tools for developers are popping up almost every month, often bringing new ways to speed up coding, analyze projects, or automate routine tasks that until recently were done entirely by hand. The market offers a wide range of options — Copilot, Claude, Codex, or ChatGPT — but the tool that fundamentally changed my daily workflow with code is the Cursor editor.

After several months of daily use, I can say quite openly that my productivity as a developer has increased by roughly fifty percent — not because of a new framework, a faster machine, or a different tech stack, but mainly because of how I think about working with code and how I use AI inside the development environment.

## What is Cursor editor

Cursor is a modern AI-powered IDE built on top of Visual Studio Code. Its main added value is the deep integration of AI directly into the development workflow. Unlike typical AI tools, the AI here is not just a chatbot or a code-generation helper; it acts as an active part of the environment, able to analyze the project, suggest changes, and collaborate with the developer on solving problems.

Cursor can, for example, analyze the whole project, refactor code, generate tests, run code review, suggest architecture, or prepare pull requests — and all of this happens in the context of the full codebase. That’s a crucial difference from tools that only work with single files or code snippets.

## What a developer’s work actually looks like

In practice, a large part of a developer’s work is not writing new features but doing things that are less visible yet essential for quality and stability: code reviews, bug analysis, refactoring older parts of the system, adding tests, checking fixes, or preparing pull requests. These tasks repeat almost every day.

They are necessary for the long-term health of the project, but they can also be time-consuming and repetitive. In exactly these situations, an AI coding assistant like Cursor becomes extremely useful, because it can significantly speed up a lot of this work.

## Auto Mode as the key feature

One feature I use most often in Cursor is Auto Mode. It lets the AI analyze a problem, propose a solution, edit the code, create tests, and prepare a commit in a single workflow. Of course, the basic rule still holds: AI is not a replacement for the developer but a tool that helps increase productivity and speed up certain parts of the job.

From a cost perspective, Cursor’s subscription is worth mentioning — around sixty dollars per month — which, given the amount of time saved and the gain in efficiency, is a very reasonable investment.

## AI model support: Claude, Codex, and more

A big advantage of Cursor is support for multiple AI models, including Claude, Codex, and other advanced models you can use for more complex code analysis or heavier refactoring.

The subscription includes a certain amount of credits for premium models, but with heavy use they can run out fairly quickly. I keep my own API tokens for these services so Cursor can use them as a fallback.

That way you can split the workflow: routine operations use the base model, while complex analysis or demanding refactoring can use models like Claude or Codex. That lets you balance both speed and cost.

## Cursor skills and custom workflow

After a while I realized that Cursor’s real strength is not only the AI model itself but the combination of AI, rules, and so-called skills that define specific workflows.

So I started creating my own Cursor skills and rules that describe workflows for different kinds of tasks: code review, generating tests, SQL optimization, security audits, or creating pull requests.

The repository with these rules is available here:

[https://github.com/pekral/cursor-rules](https://github.com/pekral/cursor-rules)

The idea is simple: instead of explaining to the AI every time what I need, I define a rule once and then reuse it across projects.

## A practical example

A typical example is rewriting a PHPUnit test into Pest syntax — a task that could otherwise take a lot of time, especially when there are many tests.

A simple prompt is enough:

```
@.cursor/skills/rewrite-tests-pest SubscriberDataVokativesTest::class
```

Cursor then analyzes the test, rewrites it to Pest syntax, adjusts the structure, and keeps the original logic. My job is to review the result, maybe tweak it a bit, or discard the change if it’s not suitable.

That’s when AI stops feeling like an experimental technology and starts working as a real day-to-day tool.

## Automated code review and pull requests

I also use Cursor when preparing pull requests. The workflow usually looks like this: the AI runs a code review first, then runs the defined rules, and then drafts the pull request.

The pull request is only created if tests pass, code quality checks pass, and any other defined rules are satisfied. If any condition fails, the pull request simply isn’t created.

So the AI can act as a kind of gatekeeper for code quality, helping keep the project consistent and up to standard.

## How AI changed my workflow

After several months of working with AI tools, the biggest benefits for me are: much less repetitive work, faster refactoring, better test coverage, and more effective code review.

I also have more time for real architectural and system-level problems — the part of the work that adds the most value to the project.

## AI as a good servant

One important rule still holds: the developer must steer the AI, not the other way around. If the developer doesn’t understand the system architecture or the application context, the AI won’t save them.

But when the developer knows what they’re doing, AI can be an extremely powerful tool that multiplies productivity and lets them focus on what really matters in development.

## Conclusion

Cursor has become my main tool for software development. I often compare it to an exoskeleton for developers: you still do the work yourself, but you can handle much more of it with less effort.

If you’re interested in how I use Cursor and AI in development, you can take a look at my rules repository:

[https://github.com/pekral/cursor-rules](https://github.com/pekral/cursor-rules)

You might find that you no longer have to do some things by hand either.
