# Emergency Response Agent - Agentic AI System

This project is a Laravel-based MVP of an Emergency Response System. It uses a **Multi-Agent Architecture** to process emergency messages, evaluate risks, and provide actionable instructions.

## 🧠 Architecture

The system uses 4 distinct agents (classes) that work sequentially to simulate collaboration:

1.  **InputAnalyzerAgent**: Extracts keywords and detects the emergency type (Fire, Health, Accident, Natural Disaster).
2.  **RiskAssessmentAgent**: Evaluates the risk level based on the emergency type and keyword severity (Low, Medium, High, Critical).
3.  **DecisionAgent**: Selects appropriate safety actions based on the classified emergency and risk level.
4.  **ActionAgent**: Formats the final response, adds professional instructions, and includes a legal disclaimer.

## 📂 Key Files

-   **Backend Agents**: `app/Services/Agents/`
    -   `InputAnalyzerAgent.php`
    -   `RiskAssessmentAgent.php`
    -   `DecisionAgent.php`
    -   `ActionAgent.php`
-   **Controller**: `app/Http/Controllers/EmergencyController.php`
-   **Routes**:
    -   API: `routes/api.php` (`POST /api/analyze`)
    -   Web: `routes/web.php` (Frontend)
-   **Frontend**: `resources/views/welcome.blade.php` (Modern, dark-themed UI)

## 🚀 How to Run locally

1.  **Start the Laravel Server**:
    ```bash
    php artisan serve
    ```
2.  **Access the Frontend**:
    Open your browser at `http://localhost:8000`.

3.  **Test the API (Optional - Postman/Curl)**:
    -   **URL**: `http://localhost:8000/api/analyze`
    -   **Method**: `POST`
    -   **Body**:
        ```json
        {
          "message": "There is a massive fire with smoke coming from the basement"
        }
        ```

## ⚠️ Disclaimer
This AI does not replace emergency services. In a real emergency, always call local emergency numbers (e.g., 911 or 112) immediately.
