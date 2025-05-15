async function sendMessage() {
  const input = document.getElementById("userInput").value;
  const responseDiv = document.getElementById("responseDiv");

  if (!input.trim()) {
    responseDiv.innerHTML =
      "<span class='text-red-500'>Please enter a message.</span>";
    return;
  }

  responseDiv.innerHTML =
    "<span class='animate-pulse text-[#00503c]'>Loading...</span>";

  try {
    const apiKey = "AIzaSyAyO2vymLxnmOs6OlHGSXBNH0mi3fr0htA";

    const response = await fetch(
      `https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=${apiKey}`,
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          contents: [
            {
              role: "user",
              parts: [
                {
                  text: `Sumagot ng tagalog at mag suggest ng masustansyang pagkain  at ibigay ang vitamis and nutrients na makukuha dito by bullet at portion na nakabase sa halagang ito
. ${input}`,
                },
              ],
            },
          ],
        }),
      }
    );

    const data = await response.json();
    const output =
      data.candidates?.[0]?.content?.parts?.[0]?.text ||
      "No response received.";
    responseDiv.innerHTML = output.replace(/\n/g, "<br>");
  } catch (error) {
    responseDiv.innerHTML =
      "<span class='text-red-500'>Error: " + error.message + "</span>";
  }
}
