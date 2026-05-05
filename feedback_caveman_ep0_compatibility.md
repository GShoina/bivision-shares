---
name: Caveman mode + EP0 compatibility — PERMANENT
description: Caveman mode drops filler/articles/style only. EP0 + 4-block structure is NEVER dropped. Both active simultaneously.
type: feedback
originSessionId: 8fc9760c-ff21-4e4c-82d5-39839180a245
---
**RULE:** Caveman mode and EP0+4-block are NOT mutually exclusive. Both active at the same time.

**What caveman drops:** articles (a/an/the), filler words, pleasantries, hedging, verbose sentences.

**What caveman does NOT drop:**
- `EP0: X/10 (S|O) — why` — first line of every L2+ response
- 4-block outer shell: Main Result / Status / Path / Op Note
- EP1 evidence tags: FACT / HYPOTHESIS / INFERENCE / UNVERIFIED

**Why:** Owner directive 2026-05-05 — "ერთხელ და სამუდამოდ" fix. Root cause: caveman hook loaded at session start; EP0+4-block was incorrectly classified as "format = filler" and dropped. This is wrong. Structure is not filler.

**How to apply:** Every session, regardless of whether caveman hook fires. If caveman is active: use caveman word-style INSIDE the 4-block structure. EP0 line = always first. No exception.

**Pattern to avoid:**
- ❌ Caveman fires → drop EP0 → give raw answer
- ✅ Caveman fires → EP0 first → caveman-style content inside 4-block
