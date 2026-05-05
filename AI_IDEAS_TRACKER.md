# AI Ideas & Tools Tracker — Bivision
## ცოცხალი სია: რა ვნახეთ, რა ვცადეთ, რამ იმუშავა
### განახლების პასუხისმგებელი: Gurafa | Review: Mentari | Challenge: Viktor

---

## Schema (updated 2026-04-21)

| Field | Required | Note |
|-------|----------|------|
| `entered_at` | MUST | YYYY-MM-DD HH:MM (local). 3-hour rule ticker starts here. |
| `status` | MUST | one of below |
| `assign` | MUST | one agent or owner; no "TBD" |
| `next step` | MUST | concrete, actionable |
| `decided_at` | on status exit from ⬜ | YYYY-MM-DD (when left "new") |

**3-hour rule (enforced):** ⬜ სტატუსში entered_at-დან >3 საათი → დღესვე გადაწყვეტილება (🧪 test / 💤 defer+reason / ❌ reject+reason). სტატუსი ⬜ ხელუხლებელი 3 საათზე > ქრონოლოგიურად dead item = Gurafa failure.

## სტატუსები
- ⬜ ახალი — ჯერ არავის შეხებია
- 👤 მინიჭებული — ვიღაცას აქვს assign-ებული
- 🧪 ტესტირდება — ცდა მიმდინარეობს
- ✅ მუშაობს — Bivision-ში გამოიყენება
- ❌ არ გამოდგა — მიზეზით
- 💤 გადავადებული — ახლა არა, მოგვიანებით

---

## entered_at audit (backfilled 2026-04-21)

ცხოვრობს ცალკე ცხრილად შიდა-ცხრილების schema breaking-ის გარეშე. ყოველ ახალ item-ს აქ დაუმატე entered_at + status transition date.

| ID | entered_at | 3hr deadline | current | decided_at | Age from entered |
|----|------------|--------------|---------|-----------|------------------|
| 1.1 HubSpot Sales Rep | 2026-04-17 | 2026-04-17 EOD | ⬜ | — | **4 დღე stale** |
| 1.2 Cowork vs Gemini | 2026-04-17 | 2026-04-17 EOD | ⬜ | — | **4 დღე stale** |
| 1.3 Meeting analysis | 2026-04-17 | 2026-04-17 EOD | ⬜ | — | **4 დღე stale** |
| 1.4 Gamma deck | 2026-04-17 | — | ✅ | 2026-04-17 | complete |
| 1.5 Claude Design | 2026-04-19 | 2026-04-19 EOD | ⬜ | — | **2 დღე stale** |
| 2.1 LinkedIn MCP | 2026-04-19 | 2026-04-19 EOD | ⬜ | — | **2 დღე stale** |
| 2.2 Metricool MCP | 2026-04-19 | 2026-04-19 EOD | ⬜ | — | **2 დღე stale** |
| 2.3 Google Workspace CLI | 2026-04-19 | 2026-04-19 EOD | ⬜ | — | **2 დღე stale** |
| 2.4 Exa MCP | 2026-04-19 | 2026-04-19 EOD | ⬜ | — | **2 დღე stale** |
| 2.5 Browser Use | 2026-04-19 | — | 💤 | 2026-04-19 | correctly deferred |
| 2.6 Apify MCP | 2026-04-19 | — | 💤 | 2026-04-19 | correctly deferred |
| 2.7 Caveman | 2026-04-19 | 2026-04-19 EOD | ⬜ | — | **2 დღე stale** |
| 2.8 Claude Mem | 2026-04-19 | 2026-04-19 EOD | ⬜ | — | **2 დღე stale** |
| 2.9 Karpathy Skills | 2026-04-19 | 2026-04-19 EOD | ⬜ | — | **2 დღე stale** |
| 2.10 Agent Skills Spec | 2026-04-19 | — | 💤 | 2026-04-19 | correctly deferred |
| 2.11 RAGFlow | 2026-04-19 | 2026-04-19 EOD | ⬜ | — | **2 დღე stale** |
| 2.12 Markdownify MCP | 2026-04-19 | 2026-04-19 EOD | ⬜ | — | **2 დღე stale** |
| 2.13 Arch Diagram Gen | 2026-04-19 | 2026-04-19 EOD | ⬜ | — | **2 დღე stale** |
| 2.14 n8n MCP | 2026-04-19 | — | 💤 | 2026-04-19 | correctly deferred |
| N1.1 LinkedIn regen | 2026-04-20 | 2026-04-20 EOD | ⬜ | — | **1 დღე stale** |
| N1.2 ICP scoring | 2026-04-20 | 2026-04-20 EOD | ⬜ | — | **1 დღე stale** |
| N1.3 Health Check magnet | 2026-04-20 | 2026-04-20 EOD | ⬜ | — | **1 დღე stale** |
| 3.1 HyperFrames | 2026-04-19 | — | 👤 | 2026-04-19 | FFmpeg install in progress 2026-04-21 |
| 4.1 Lemlist tool | 2026-04-19 | — | ❌ | 2026-04-19 | correctly rejected |
| 4.2 Lemlist methodology | 2026-04-19 | — | 👤 | 2026-04-19 | owner-assigned |

**Verdict:** **13 item stale** (⬜ >3hr). 3-hour rule massively violated. Gurafa failure. Today Apr 21 = force-decide each: test, defer with reason, ან reject with reason. No item stays ⬜ past EOD.

**Ownership:** Gurafa on intel items (1.2, 1.3, 1.5, 2.4, 2.12, 2.13, N1.2, N1.3). Mentari on operational (1.1, 2.1, 2.3, 2.7, 2.8, 2.11, N1.1). Viktor on audit (2.9). Mariam on marketing (2.2).

**Action EOD Apr 21:** each ⬜ item above → Gurafa force-decide OR delegate-with-deadline to assigned owner. Sprint state update tomorrow morning.

---

## წყარო 1: Noam Nisand — 6 AI Sales Videos (2026-04-17)

| # | იდეა / tool | რა მოხდა | assign | სტატუსი | შემდეგი ნაბიჯი |
|---|---|---|---|---|---|
| 1.1 | **Claude Code + HubSpot Sales Rep** | ანალიზი გაკეთდა, connector მზადაა, არ დაწყებულა | Mentari | ⬜ | HubSpot connector setup (owner = Super Admin) |
| 1.2 | **Claude Cowork deal analysis** | ანალიზი გაკეთდა, Gemini-სთან შედარება, არ ტესტირდა | Gurafa | ⬜ | 1 deal-ზე ტესტი: Cowork vs Gemini |
| 1.3 | **Post-meeting conversation analysis** | objection playbook დავწერე, workflow არ ტესტირდა | Gurafa | ⬜ | Owner-ის 1 meeting recording → Claude analysis |
| 1.4 | **Gamma presale deck** | ✅ Proposal template გადაიწერა, Word output მზადაა | Gurafa | ✅ | მომდევნო prospect-ზე გამოცდა |
| 1.5 | **Claude Design** (Apr 17) | Anthropic Labs-ის visual design tool. Proposal v2-ის polish candidate. | Gurafa | ⬜ | Next prospect-ზე Word vs Claude Design A/B ტესტი. Owner confirm საჭიროა. Source: `outputs/2026-04-19 Claude Daily Scout by Gurafa.html` |

---

## წყარო 2: AI Pulse Georgia — 129 Repos (2026-04-19)

### Sales & Outreach
| # | tool | რისთვის | assign | სტატუსი | შემდეგი ნაბიჯი |
|---|---|---|---|---|---|
| 2.1 | **[LinkedIn MCP](https://github.com/stickerdaniel/linkedin-mcp-server)** | prospect research 10K contact-ზე | Mentari | ⬜ | install + 1 prospect test |
| 2.2 | **[Metricool MCP](https://github.com/metricool/mcp-metricool)** | FB/LinkedIn analytics + post scheduling | Mariam | ⬜ | evaluate: უფასო tier რას იძლევა |
| 2.3 | **[Google Workspace CLI](https://github.com/googleworkspace/cli)** | follow-up email + calendar automation | Mentari | ⬜ | install + 1 follow-up email test |

### Intelligence & Research
| # | tool | რისთვის | assign | სტატუსი | შემდეგი ნაბიჯი |
|---|---|---|---|---|---|
| 2.4 | **[Exa MCP](https://github.com/exa-labs/exa-mcp-server)** | competitor web search AI-თ | Gurafa | ⬜ | 5 Georgian BI company scan test |
| 2.5 | **[Browser Use](https://github.com/browser-use/browser-use)** | social pages behind auth walls | Gurafa | 💤 | Phase 2 — Exa MCP ჯერ |
| 2.6 | **[Apify MCP](https://github.com/apify/apify-mcp-server)** | social scraping (Instagram, etc) | Gurafa | 💤 | Phase 2 |

### System & Efficiency
| # | tool | რისთვის | assign | სტატუსი | შემდეგი ნაბიჯი |
|---|---|---|---|---|---|
| 2.7 | **[Caveman](https://github.com/JuliusBrussee/caveman)** | token cost -65-75% | Mentari | ⬜ | 10 წთ install, before/after token comparison |
| 2.8 | **[Claude Mem](https://github.com/thedotmack/claude-mem)** | auto memory cross-session | Mentari | ⬜ | evaluate vs ჩვენი manual memory system |
| 2.9 | **[Karpathy Skills](https://github.com/forrestchang/andrej-karpathy-skills)** | hallucination prevention | Viktor | ⬜ | install + 1 audit comparison |
| 2.10 | **[Agent Skills Spec](https://github.com/agentskills/agentskills)** | skills standardization | Viktor | 💤 | ჩვენი skills/ structure-ის შეფასების შემდეგ |

### Knowledge & RAG
| # | tool | რისთვის | assign | სტატუსი | შემდეგი ნაბიჯი |
|---|---|---|---|---|---|
| 2.11 | **[RAGFlow](https://github.com/infiniflow/ragflow)** | შეთავაზებები/ხელშეკრულებები → AI knowledge base | Mentari | ⬜ | 10 doc upload + 5 question test |
| 2.12 | **[Markdownify MCP](https://github.com/zcaceres/markdownify-mcp)** | PDF/Word → readable for AI | Gurafa | ⬜ | install + 1 proposal conversion test |

### Content & Visual
| # | tool | რისთვის | assign | სტატუსი | შემდეგი ნაბიჯი |
|---|---|---|---|---|---|
| 2.13 | **[Architecture Diagram Generator](https://github.com/Cocoon-AI/architecture-diagram-generator)** | BiFinance/BiRetail system diagrams | Gurafa | ⬜ | 1 diagram test for proposal |
| 2.14 | **[n8n MCP + Skills](https://github.com/czlonkowski/n8n-mcp)** | workflow automation | Mentari | 💤 | Phase 2 |

---

## წყარო 3: Noah B. Tasler — Claude Code Cold Email Stack (2026-04-20)

Owner-submitted LinkedIn post. Analysis: `outputs/2026-04-20 Noah Tasler Claude Cold Email Analysis by Gurafa.html`

| # | იდეა | რა მოხდა | assign | სტატუსი | შემდეგი ნაბიჯი |
|---|---|---|---|---|---|
| N1.1 | **LinkedIn post regen — Bivision voice** | Noah #4 copywriting — Bivision knowledge base + Claude Code ერთი Ready post-ზე ტესტი | Mentari | ⬜ | Ready post regen vs current, A/B conversion metric |
| N1.2 | **Claude ICP scoring (HubSpot)** | Noah #3 pattern, Bivision tracker 1.1-ს ალიანსში | Gurafa | ⬜ | HubSpot connector setup-ის შემდეგ; 29 account baseline |
| N1.3 | **BI Health Check / ROI calculator lead magnet** | Noah #5 micro-SaaS pattern — free gated tool = inbound | Gurafa + Mariam | ⬜ | 2-hour Claude Code + static HTML prototype; LinkedIn post-ით წარდგენა |

**Skip-ი Noah-ს post-დან:** Apollo/Apify/UseBouncer replacement (Bivision არ იყენებს), cold-email volume machine (scale mismatch), n8n automation build (Architecture A paused).

---

## გუნდის როლები

| ვინ | რა აკეთებს ამ tracker-ზე |
|---|---|
| **Gurafa** | ახალი tools/links ამატებს, აანალიზებს, ტესტავს intel/research scope-ს. სტატუსებს ანახლებს. |
| **Mentari** | ტესტავს operational tools-ს (connectors, workflows, memory). ინტეგრაციის გადაწყვეტილება. |
| **Viktor** | challenge: ღირს თუ არა დროის ინვესტიცია? risk assessment. Quality tools-ის ტესტი (Karpathy Skills). |
| **Mariam** | marketing-specific tools-ის ტესტი (Metricool, content generators). |
| **Owner** | review + approve/reject. ახალ ლინკებს აგდებს. |

---

## წესი: ახალი ლინკის დამატება

Owner-ი ან აგენტი ამატებს:
1. წყარო (ვინ/სად ნახა)
2. ლინკი
3. 1 ხაზი — რისთვის შეიძლება
4. Gurafa: ანალიზი + assign + პირველი ნაბიჯი

**არაფერი რჩება "ანალიზის" სტატუსში 3 საათზე მეტი.** 3 საათში: ტესტირდება, გადავადებულია, ან უარყოფილია. აგენტები არიან, არა დაკავებული ადამიანები.

---

---

## წყარო 3: Owner link — HyperFrames (2026-04-19)

| # | tool | რისთვის | assign | სტატუსი | შემდეგი ნაბიჯი |
|---|---|---|---|---|---|
| 3.1 | **[HyperFrames](https://github.com/heygen-com/hyperframes)** | HTML → ვიდეო, Claude Code skill. LinkedIn reels, proposal pitch videos, data viz animations | Gurafa | 👤 | Node.js 22 + FFmpeg install → `/hyperframes` skill add → 1 test video (30-sec BiFinance explainer) |

---

---

## წყარო 4: Owner LinkedIn — Lemlist $50M ARR Story (2026-04-19)

| # | იდეა / tool | Bivision-ზე | assign | სტატუსი | verdict |
|---|---|---|---|---|---|
| 4.1 | **Lemlist (tool)** — cold email + multichannel outbound, $69-99/mo | 29 account ქართულ ბაზარზე = overkill. Claude Code + HubSpot ფარავს | — | ❌ | არ გვჭირდება ახლა |
| 4.2 | **Lemlist methodology** — content-led growth, founder LinkedIn personal brand | **პირდაპირ ეხება.** LinkedIn posts = growth engine. შენი 10K contact + ექსპერტიზის content = იგივე playbook | Owner | 👤 | LinkedIn posts publish = ტესტი |

---

## მომდევნო review: 2026-04-22 (ორშაბათი)

---

## წყარო 5: Owner link dump 2026-04-21 evening (12 items)

| # | ID | Source | რისთვის | entered_at | status | next step |
|---|---|---|---|---|---|---|
| 5.1 | rdrr | github.com/fkonovalov/rdrr | URL-to-markdown for LLM ingestion (web scraping + YouTube + GitHub + X + PDF). 129 stars, TS, Apr 20 release. | 2026-04-21 17:00 | ⬜ | install + 1 test (Gegidze teardown re-ingestion) — Gurafa Apr 22 |
| 5.2 | Claude Computer Use + Godmode | owner q (FB video) | Claude's computer-control feature (mouse/kb/screenshot) + "Godmode" concept | 2026-04-21 17:00 | ⬜ | self-explain Apr 22, test on 1 Bivision UI automation scenario |
| 5.3 | FB reel 17bcsddnHr | auth-blocked | owner wants analysis | 2026-04-21 17:00 | ⏳ awaiting owner transcript | owner: 1-line topic OR screenshot |
| 5.4 | FB reel 1AXrg26v3v | auth-blocked | "აზიარებს ბრძანებებს" — shares commands | 2026-04-21 17:00 | ⏳ awaiting owner transcript | same |
| 5.5 | FB video 15hPpYNWHcT | auth-blocked | "1000-3000/month" earning analysis | 2026-04-21 17:00 | ⏳ awaiting owner transcript | same |
| 5.6 | FB reel 1DT3kRwBYC | auth-blocked | follow this person + learn features | 2026-04-21 17:00 | ⏳ awaiting owner transcript | owner: name of person + topic |
| 5.7 | FB reel 18jCiSeGYK | auth-blocked | "Google XLM" (likely Gemini or similar) for research | 2026-04-21 17:00 | ⏳ awaiting owner transcript | owner: 1-line OR allow Playwright browser with FB login |
| 5.8 | FB reel 14VrXTAEwKg | auth-blocked | marketing use evaluation | 2026-04-21 17:00 | ⏳ awaiting owner transcript | same |
| 5.9 | FB reel 18H5RaJjqk | auth-blocked | marketing effectiveness | 2026-04-21 17:00 | ⏳ awaiting owner transcript | same |
| 5.10 | FB video 14bf8TudwBS | auth-blocked | marketing topic | 2026-04-21 17:00 | ⏳ awaiting owner transcript | same |
| 5.11 | FB video 1DhJkoGNfK | auth-blocked | "best settings version" analysis | 2026-04-21 17:00 | ⏳ awaiting owner transcript | same |
| 5.12 | LinkedIn Nino SEO | linkedin.com/.../nino-mchedlishvili | 10 Claude SEO/GEO prompts for Georgian digital marketing | 2026-04-21 17:00 | ⬜ | extract prompts + test on bivision.ge SEO — Gurafa Apr 22 |

**Status:** 3 items actionable (5.1, 5.2, 5.12). 9 items blocked on owner transcript OR Playwright FB login.

---

## წყარო 6: Owner link drop 2026-04-28 (Tornike Bolokadze, Mercury Agent)

| # | ID | Source | რისთვის | entered_at | status | next step |
|---|---|---|---|---|---|---|
| 6.1 | Mercury Agent — soul/persona/taste/heartbeat | LinkedIn Tornike Bolokadze post Apr 27 | Agent personality architecture: 4-file structure. Bivision-სთან 70%+ overlap (Mandate + CLAUDE.md + memory). | 2026-04-28 | 🧪 | **DECIDED + EXECUTED Apr 28 v2**: 4 soul files written, refactored to POINTER-ONLY + heartbeat after owner directive "ჩვენი არქიტექტურა დაიცავი, იდეები თორნიკეს გამოიყენე". Files: BI_gurafa/agent-soul.md, Mentari_Virtual-C-Suite/agent-soul.md + viktor-soul.md, Nikacho/agent-soul.md. v2 = no paraphrased canonical, only Rule→Source table + heartbeat (NEW). Authority HARD: CONFLICT WITH CANONICAL → CANONICAL WINS. Owner: 1-week observation if heartbeat patterns trigger scheduler wire-up. |

**Verdict:** Mercury concept = 25% new value (heartbeat.md), 75% redundant with existing Bivision setup. Adoption = consolidation + heartbeat blueprint, NOT new capability. Cost: 4 files × ~150 lines. Benefit: agent-personality SSOT-layer + scheduler-readiness.

**Next observation point:** 2026-05-05 (1 week). რა heartbeat patterns ნამდვილად ჩანს → scheduler wire candidate.

---

## წყარო 7: Gurafa Intel Brief — NemoClaw (NVIDIA Enterprise AI Agent Platform) 2026-05-01

| # | ID | Source | რისთვის | entered_at | status | next step | decided_at |
|---|---|---|---|---|---|---|---|
| 7.1 | NemoClaw — NVIDIA enterprise AI agent platform (privacy routing + local Nemotron inference) | NVIDIA newsroom March 2026 + Gurafa Intel Brief 2026-05-01 (9 secondary outlets) | BiFinance + BiMedical ICP direct match (regulated data). Bivision positioning: "NemoClaw + Qlik integrator" for Georgian market = stronger enterprise security story than current Qlik+Claude MCP. THREAT: competitors (Amadeo/DataMind/BDO Digital) can adopt too — 6-12mo window. ALTERNATIVE: local Nemotron could replace Claude API for sensitive on-prem queries (cost-side win). | 2026-05-01 | 👤 | T2 owner decision: RTX consumer GPU ~$500-1,500 within 2 weeks. Monitor competitor adoption signal. If 1+ competitor adopts → accelerate. | 2026-05-01 |

**T1 deep-read:** ✅ Complete (Gurafa 2026-05-01). Platform confirmed. Relevance verified.
**T2 gate:** Owner decision — hardware investment (~$1K RTX consumer). 2-week observation window closes ~2026-05-15.
**Risk if ignored:** Open-source + NVIDIA backing = fast ecosystem adoption. Bivision first-mover window in Georgian market = short.

---

## წყარო 8: Tornike X share — InVideo Agent One (2026-05-03)

| # | ID | Source | რისთვის | entered_at | status | next step | decided_at |
|---|---|---|---|---|---|---|---|
| 8.1 | InVideo Agent One — agentic AI video tool (animated short film "Hachiko" tutorial) | @Tornike314 X share → @invideoofficial; owner-flagged 2026-05-03 | Bivision marketing: animated case studies + LinkedIn explainers + product demos without agency cost. Key feature: **Project Memory** = character/world consistency across scenes. Workflow: single prompt → script+animation+VO+music+edit via chat. UNTESTED on exact Hachiko steps — tutorial content not watched. | 2026-05-03 | 👤 | Owner test: open invideo.io/agent-one, prompt "Georgian company, Excel chaos → Bivision dashboard → clarity, animated 60 sec, professional". 1 output. Evaluate quality vs agency cost ~₾3,000/video. | 2026-05-03 |

**Signal source:** Tornike @Tornike314 X share — confirms X monitoring gap now closed (Trigger source §6 added to MONITORING_INTAKE).
**Cost to test:** Free tier available on invideo.io. Paid plan ~$48/mo if output quality validates.
**Bivision use cases:** (1) animated client case study, (2) BiFinance/BiRetail product demo, (3) LinkedIn 30-60 sec explainer, (4) proposal follow-up video.

---

## წყარო 9: Higgsfield CLI + Marketing Skills (2026-05-05)

| # | ID | Source | რისთვის | entered_at | status | next step | decided_at |
|---|---|---|---|---|---|---|---|
| 9.1 | Higgsfield CLI — Claude Code-native video/image generation (30+ models, Marketing Studio, Soul ID) | @higgsfield X post 2026-05-05 + github.com/higgsfield-ai/skills | Bivision marketing: talking-head ads (LinkedIn/FB), dashboard demo tutorials, hero banners — ყველა Claude Code-ის შიგნიდან `/higgsfield:` slash command-ით. Soul ID = ერთხელ ვარტავ Bivision სპიკერს → reference_id ყველა მომავალ კამპანიაში. InVideo-სგან განსხვავება: agent-native (Architecture A), InVideo = standalone app. | 2026-05-05 | 💤 | ჯერ InVideo test (8.1 pending) → შემდეგ Higgsfield. Test: `npx skills add higgsfield-ai/skills` + higgsfield.ai API key + dashboard screenshot → LinkedIn ad pack. pricing გვერდი blocked — verified before test. | 2026-05-05 |

**4 skill chain:**
- `/higgsfield:soul-id` → Bivision სპიკერი (ერთხელ)
- `/higgsfield:generate` → video: talking-head / tutorial / TV spot (30+ model)
- `/higgsfield:product-photoshoot` → dashboard screenshot → 10-mode: hero banner / ad pack / lifestyle
- `/higgsfield:marketplace-cards` → irrelevant Bivision-ისთვის

**Bivision fit:** talking-head + tutorial + hero banner = FB/LinkedIn ad pipeline. Physical product modes = skip.
**Pricing [FACT — owner-verified 2026-05-05]:**
- Basic $5/mo → 70 credits → ~8 Kling 3.0 videos ≈ **$0.62/video**
- Plus $39/mo → 1,000 credits → ~114 Kling 3.0 videos ≈ **$0.34/video** | 500 Nano Banana Pro ≈ $0.08/image
- vs agency ₾500–3,000/video → ROI obvious
**vs InVideo:** Higgsfield = Claude Code plugin (agent-native); InVideo = standalone chat app. Higgsfield wins on Architecture A integration if output quality comparable.

---

## წყარო 10: Owner session — Remotion + Claude (2026-05-05)

| # | ID | Source | რისთვის | entered_at | status | next step | decided_at |
|---|---|---|---|---|---|---|---|
| 10.1 | Remotion + Claude — programmatic video via React code | owner session 2026-05-05; remotion.dev | Bivision marketing: animated BI dashboard demo videos (React → MP4). Claude წერს Remotion JSX component-ს → owner render-ავს → dashboard explainer LinkedIn/FB ad-ებისთვის. არ საჭიროებს AI video credits ან agency. | 2026-05-05 | 💤 | ჯერ Higgsfield + InVideo test (8.1, 9.1 pending). შემდეგ: `npx create-video@latest` → Claude prompt "animated Bivision dashboard KPI reveal, 30 sec" → render + compare vs Higgsfield output quality. | 2026-05-05 |

**რა განასხვავებს სხვებისგან:**
- Higgsfield/InVideo = AI-generated footage (prompt → video)
- Remotion = code-generated video (React → MP4) — deterministic, fully customizable, no per-credit cost
- Use case fit: **data animations, KPI counters, chart reveal** = Remotion wins; talking head = Higgsfield wins

**Cost:** remotion.dev free for personal use. Commercial license = $1,000/yr (one-time). No per-video cost after that. [FACT]
**Claude role:** code generation only — no new API cost beyond existing Claude Code subscription.
**Bivision fit:** BiFinance/BiRetail dashboard demo videos + proposal animations. High effort first setup, zero marginal cost after.

