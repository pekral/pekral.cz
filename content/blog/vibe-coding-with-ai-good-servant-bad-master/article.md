---
date: 2026-02-04
description: AI vibe coding can boost productivity, but without a clear workflow and human oversight, outputs can quickly get out of hand. My take on tools like Cursor and Claude, the role of AI rules, and why code review still matters.
---

# Vibe coding with AI — good servant, bad master? My take and workflow

When people talk about “AI vibe coding”, they might picture a programmer who just tells the computer “build me an app” and it magically appears. Reality is a bit different — and I deal with that every day.

There are some interesting tools and approaches out there today: **Cursor** (an AI-first editor built around generative agents), **Claude Code** (CLI-based code agent), **Google Antigravity** (agent-first IDE), or **OpenAI Codex**, which is expanding into editors and CI/CD environments.

## It starts like any other project

In my workflow, I begin by getting or writing a brief — what needs to be built. Then I use plan mode to generate a step-by-step plan for how the AI will work and what it will do.

Without a clear plan, the AI will still produce output, but the quality won’t be good.

## AI rules — and suddenly it makes sense

Generating code without defined rules is like sending a team on an expedition without a map — they might find something, but it’s more luck than result.

That’s why I use AI rules that define style, architecture, conventions, and output quality. I maintain these rules as open source at [github.com/pekral/cursor-rules](https://github.com/pekral/cursor-rules) — and it makes a noticeable difference in consistency and usability of the generated code.

## Vibe coding is a great assistant … but

I run “vibe coding” itself, which includes:

1. Code generation with rules,
2. Internal QA — linting, tests, and coverage,
3. Iteration: the model fixes issues and improves quality until new code reaches the target coverage.

In this mix I use different models:

- **Opus** for the actual code generation,
- **Codex** for code review and documentation,
- **ChatGPT** for clarifying or refining the brief.

AI helps, but you still need to check the results and think about what you want to get.

## Humans still need to review — code review is essential

My favourite saying is: *AI is a good servant but a bad master.* That means I don’t sit back and wait for the AI to do everything — I still do code review, fix what’s needed, and test the results.

I even have an agent set up for code review that runs in parallel with my own review — it gives me extra feedback according to my rules. It works: it helps me catch small deviations and bugs before they reach production.

## The workflow isn’t free — you have to think about cost

Don’t expect “wow, this is cheap” — this workflow is expensive if you run it continuously with multiple models and agents. You’re running generation, testing, code review, coverage — all of that costs money and time.

The hype around AI has to be balanced with the fact that sometimes it’s faster and more effective to write a piece of code by hand than to keep tweaking it with AI.

## I use AI every day, but carefully

I work with AI every day — that’s just the reality of modern development. It’s a great helper, especially for repetitive tasks and refactoring. But AI isn’t all-powerful — there are tasks where I’d be faster than the AI, because the AI may be busy gathering context where I’d do it more quickly myself.

AI is great for prototyping and brainstorming, but production-ready code is still a matter of human judgment.

---

## In short

AI vibe coding is changing how we build software: tools like Cursor, Claude Code, Antigravity, or Codex give developers a big productivity boost. But without a solid workflow, clear rules, and human oversight, the outputs can quickly get out of hand.

Use AI — but use it wisely.

---

*[Original article in Czech (LinkedIn)](https://www.linkedin.com/pulse/vibe-coding-ai-dobr%C3%BD-sluha-%C5%A1patn%C3%BD-p%C3%A1n-m%C5%AFj-dne%C5%A1n%C3%AD-n%C3%A1zor-petr-kr%C3%A1l-u35pe/)*
